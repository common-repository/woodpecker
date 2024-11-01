<?php
/**
* Create url for filters
* @author Woodpecker Team
* @since      1.0.0
*/

class Woodpecker_URL_Builder {

  private $url = '';

  private $statusUrlList = '';

  private $perPage = 10;

  private $page = 0;

  public function __construct($url, $statusUrlList, $perPage, $page) {
    $this->url = $url;
    $this->statusUrlList = $statusUrlList;
    $this->perPage = $perPage;
    $this->page = $page;
  }

  public function getTabUrl(){
    return $this->url;
  }

  public function getCurlUrl() {
    if (!empty($this->statusUrlList)) {

      if (!empty($this->statusUrlList)) {
        $statusUrl = '';

        for ($i = 0; $i < sizeof($this->statusUrlList); $i++) {
          $statusUrl .= $this->statusUrlList[$i].',';
        }

        $curlAddress .= "&status=".substr_replace($statusUrl ,"",-1);
      }
    }

    return $curlAddress;
  }

  public function getFilters() {
    $filters = "";

    if (!empty($this->statusUrlList)) {

      if (!empty($this->statusUrlList)) {
        for ($i = 0; $i < sizeof($this->statusUrlList); $i++) {
          $filters .= '
          <div class="tags-panel__tag">
            <a href="'.$this->url.$this->getUrlWithout('status', $this->statusUrlList[$i], $this->statusUrlList).'"><span class="tags-panel__tag--close close"></span></a>
            <span class="tags-panel__tag--status">status : </span>
            <span class="tags-panel__tag--text">'.$this->statusUrlList[$i].'</span>
          </div>
          ';
        }
      }
    }

    return $filters;
  }

  private function getUrlWithout($parameterName, $valueToRemove) {
    $url = "";

    if (!empty($this->statusUrlList)) {
      if (!empty($this->statusUrlList)) {
        $statusUrl = '';

        for ($i = 0; $i < sizeof($this->statusUrlList); $i++) {
          if ($parameterName == 'status') {
            if ($valueToRemove != $this->statusUrlList[$i]) {
              $statusUrl .= $this->statusUrlList[$i] . ',';
            }
          } else {
            $statusUrl .= $this->statusUrlList[$i] . ',';
          }
        }

        if(!empty($statusUrl)){
          $url .= "&status=" . substr_replace($statusUrl ,"",-1);
        }
      }
    }

    if ($this->perPage != 0  && ($this->perPage == 10 || $this->perPage == 25
          || $this->perPage == 50 || $this->perPage == 100 || $this->perPage == 250 || $this->perPage == 500)) {
      $url .= "&per_page=" . $this->perPage;
    }

    return $this->url.$url;
  }

  public function getUrlWith($parameterName, $valueToAdd) {
    $url = "";

      if (!empty($this->statusUrlList)) {
        $statusUrl = '';
        $isStatusExist = false;

        for ($i = 0; $i < sizeof($this->statusUrlList); $i++) {
          if ($parameterName == 'status') {
            if ($valueToAdd != $this->statusUrlList[$i]) {
              $isStatusExist = true;
            }

            $statusUrl .= $this->statusUrlList[$i].',';
          } else {
            $statusUrl .= $this->statusUrlList[$i].',';
          }
        }

        if ($isStatusExist) {
          $statusUrl .= $valueToAdd.',';
        }

        if(!empty($statusUrl)){
          $url .= "&status=".substr_replace($statusUrl ,"",-1);
        }
      } else if ($parameterName == 'status') {
        $url .= "&status=".$valueToAdd;
      }

      if ($this->perPage != 0  && ($this->perPage == 10 || $this->perPage == 25
            || $this->perPage == 50 || $this->perPage == 100 || $this->perPage == 250 || $this->perPage == 500)) {
        $url .= "&per_page=" . $this->perPage;
      }

    return $this->url.$url;
  }
}
