<?php

class Pad

{

  private $name;
  private $color;
  private $url;
  private $options;
  private $selected = false;

  public function __construct($input) {

    $this->color = "#000";
    $this->options = $this->defaults();
    $this->name = trim(preg_replace('/(?=[^\]])\([a-z0-9_-]+:.*?\)/', '', $input));

    $search = preg_match('/(?=[^\]])\([a-z0-9_-]+:.*?\)/', $input, $options);
    if($search):
      $this->set_options($options[0]);
    endif;
    $this->set_urls();

  }

  public function defaults(){
    $defaults = array(
      'color'                     => "#000000",
      'type'                      => "default",
      'url'                       => false,
      'visibility'                => 'visible'
    );

    return $defaults;
  }

  public function set_options($options) {
    $tag  = trim( rtrim( ltrim( $options, '(' ), ')' ) );
    $attributes = "color|url|type|visibility";
    $search = preg_split('!(' . $attributes . '):!i', $tag, false, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);

    $num  = 0;
    $attr = array();
    // get an associative array attribute=>value
    foreach($search as $key) :
  	  if(!isset($search[$num+1])) break;
  	  $key   = trim($search[$num]);
  	  $value = trim($search[$num+1]);
  	  $this->options[$key] = $value;
  	  $num = $num+2;
    endforeach;
  }

  public function options($key){
    if(array_key_exists($key, $this->options)):
      return $this->options[$key];
    endif;
    return;
  }

  public function set_urls() {
    global $libreto;

    if($this->options['url']):
      $title = array_slice(explode('/', trim('/', $this->options['url'])), -1)[0];
      $url = trim($this->options['url'], '/ ');
    else:
      $title = urlencode(strtolower($libreto->options('name'))) . "+" . urlencode(strtolower($libreto->name())) . "+" . urlencode(strtolower($this->name));
      $url = $libreto->provider('url') . "/p/" . $title;
    endif;

    $this->url = array(
      "pad"       => $url . $libreto->options('pads_params'),
      "reader"    => "/reader/" . urlencode($libreto->name()) . '/' . urlencode($this->name),
      "url"       => "/" . urlencode($libreto->name()) . '/' . urlencode($this->name),
      "txt"       => $url . "/export/txt",
      "markdown"  => $url . "/export/markdown",
      "html"      => $url . "/export/html",
    );

  }

  public function type(){
    if(array_key_exists('type', $this->options)):
      return $this->options['type'];
    endif;
    return false;
  }

  public function color(){
    if(array_key_exists('color', $this->options)):
      return $this->options['color'];
    endif;
    return false;
  }

  public function select() {
    $this->selected = true;
    return $this;
  }

  public function selected(){
    return $this->selected;
  }

  public function url($format = 'pad') {
    global $libreto;
    if($format == "pad"):
      if($libreto->mode() == "read"):
        return $this->url['reader'];
      else:
        return $this->url['pad'];
      endif;
    endif;
    return $this->url[$format];
  }

  public function name() {
    return $this->name;
  }

  public function txt() {
    $txt = file_get_contents($this->url('txt'));
    return $txt;
  }

  public function html() {

    global $Parsedown, $Purifier, $Markdownify, $libreto;

    // we prefer to get html from markdown but if markdown export is not activated on etherpad instance, we use html export
    if($libreto->provider('markdown')):
      $markdown = file_get_contents($this->url('markdown'));
      // remove \url{} tags
      $markdown = preg_replace('#\\\url\{(.+)\}#i', '$1', $markdown);
      // replace underline tags
      $markdown = preg_replace('#underline(.+)underline#', '<u>$1</u>', $markdown);
      // strip slashes
      $markdown = stripslashes($markdown);
      // parse
      $html = $Parsedown->text($markdown);
      // sanitize
      $html = $Purifier->purify($html);
    else:
      $html = file_get_contents($this->url('html'));
      // dom load
      libxml_use_internal_errors(true); //Prevents Warnings, remove if desired
      $dom = new DOMDocument();
      $dom->loadHTML($html);
      // remove hidden divs
      foreach($dom->getElementsByTagName("div") as $div) {
        if ($div->getAttribute('style') == 'display:none') {
          $div->parentNode->removeChild($div);
        }
      }
      // get body part
      $body = "";
      foreach($dom->getElementsByTagName("body")->item(0)->childNodes as $child) {
          $body .= $dom->saveHTML($child);
      }
      // remove links
      $body = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $body);
      // remove <div>JavaScript license information</div>
      $body = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $body);
      // convert <br> to newline
      $body = br2nl($body);
      // convert to markdown
      //$markdown = $Markdownify->parseString($body);
      // parse to html
      $html = $Parsedown->text($body);
      // sanitize
      $html = $Purifier->purify($html);
    endif;
    // return
    return $html;

  }

  public function css(){
    $css = strip_tags(file_get_contents($this->url('txt')));
    return $css;
  }

  public function visible($filter = false){
    global $libreto;
    if($filter) :
      $filter = (array)$filter;
    else:
      $filter = $libreto->mode() == 'read' ? array('visible') : array('visible', 'private');
    endif;

    if(in_array($this->options('visibility'), $filter ))
    {
      return true;
    }
    return false;
  }

}
