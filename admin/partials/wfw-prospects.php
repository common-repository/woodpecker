<?php
/**
 * Admin backend for Prospects
 *
 * @link       #
 * @since      1.0.0
 * @author     Woodpecker Team
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/admin/partials
 */

if (!defined('Woodpecker_For_Wordpress_Connector_Admin')) :
    die('Direct access not permitted');
endif;

global $wpdb;

$data = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");

$url = '?page=wfw&tab=prospects';

$statusUrlList = array();
$perPage = 10;
$page = 1;


if (isset($_GET['status'])) :
  $statusUrlList = explode(",", sanitize_text_field($_GET['status']));
  $statusUrlList = array_unique($statusUrlList);
endif;

if (isset($_GET['per_page']) && $_GET['per_page'] != 0  && ($_GET['per_page'] == 10 || $_GET['per_page'] == 25
      || $_GET['per_page'] == 50 || $_GET['per_page'] == 100 || $_GET['per_page'] == 250 || $_GET['per_page'] == 500)) :
  $perPage = sanitize_text_field($_GET['per_page']);
endif;

if (isset($_GET['pageApi'])) :
  $page = sanitize_text_field($_GET['pageApi']);
endif;

$urlBuilder = new Woodpecker_URL_Builder($url, $statusUrlList, $perPage, $page);
$getconnectprospects = new Woodpecker_For_Wordpress_Connector_Curl('/rest/v1/prospects?search=tags=wordpress&per_page=' . $perPage . '&page=' . $page . $urlBuilder->getCurlUrl(),
$data->api_key);
$getjsonprospects = $getconnectprospects->getJson();
$getstatus = $getjsonprospects->status;

$fieldsData = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "wfw_forms_fields WHERE form_id = 1");

$emailCol = '';
$additionalCol = '';
$header = '<div class="prospect-content__table--row title fontDemi">
            <div class="row-table"><span class="row-table__text">' . __('Status', $this->plugin_name) . '</span></div>
            <div class="row-table"><span class="row-table__text">' . __('Name', $this->plugin_name) . '</span></div>
            <div class="row-table"><span class="row-table__text">' . __('Company', $this->plugin_name) . '</span></div>
            <div class="row-table"><span class="row-table__text">' . __('Website', $this->plugin_name) . '</span></div>';

  foreach ($fieldsData as $key) {
    $map = strtoupper($key->fields_map);
    $isShow = $key->field_state;

    if ($map != 'EMAIL' && $map != 'COMPANY' && $map != 'LAST_NAME' && $map != 'FIRST_NAME' && $map != 'WEBSITE' && $isShow) {
      $header .= '<div class="row-table"><span class="row-table__text" onmouseover="showTooltipForEllipsis(this, \'' . str_replace("_", " ", ucfirst(strtolower($map))) . '\')" onmouseout="removeTooltip()">' . __(str_replace("_", " ", ucfirst(strtolower($map))), $this->plugin_name) . '</span></div>';
    }
  }

$header .= '</div>';

if ($getstatus->status != 'ERROR' && $data->api_key != '') :
  foreach ((array)$getjsonprospects as $prosp) :
    $status = strip_tags($prosp->status);
    $firstName = strip_tags($prosp->first_name);
    $lastName = strip_tags($prosp->last_name);
    $email = strip_tags($prosp->email);
    $company = strip_tags($prosp->company);
    $website = strip_tags($prosp->website);

    $emailCol .= '<div class="prospect-content__table--item">
      <div class="row-table"><span class="row-table__text" onmouseover="showTooltipForEllipsis(this, \'' . $email . '\')" onmouseout="removeTooltip()">' . (empty($email) ? '—' : $email) . '</span></div>
    </div>';

    $additionalCol .= '<div class="prospect-content__table--row">
      <div class="row-table"><span class="row-table__text">' . (empty($status) ? '—' : $status) . '</span></div>
      <div class="row-table fontDemi"><span class="row-table__text" onmouseover="showTooltipForEllipsis(this, \'' . $firstName . " " . $lastName . '\')" onmouseout="removeTooltip()">' . (empty($firstName) && empty($lastName) ? '—' : $firstName . " " . $lastName) . '</span></div>
      <div class="row-table"><span class="row-table__text" onmouseover="showTooltipForEllipsis(this, \'' . $company . '\')" onmouseout="removeTooltip()">' . (empty($company) ? '—' : $company) . '</span></div>
      <div class="row-table"><span class="row-table__text" onmouseover="showTooltipForEllipsis(this, \'' . $website . '\')" onmouseout="removeTooltip()">' . (empty($website) ? '—' : $website) . '</span></div>';

      foreach ($fieldsData as $key) {
        $map = strtoupper($key->fields_map);
        $isShow = $key->field_state;
        $field = '';

        if ($map != 'EMAIL' && $map != 'COMPANY' && $map != 'LAST_NAME' && $map != 'FIRST_NAME' && $map != 'WEBSITE' && $isShow) {
          if ($map == 'SNIPPET_1') {
            $field = $prosp->snippet1;
          } else if ($map == 'SNIPPET_2') {
            $field = $prosp->snippet2;
          } else if ($map == 'SNIPPET_3') {
            $field = $prosp->snippet3;
          } else if ($map == 'SNIPPET_4') {
            $field = $prosp->snippet4;
          } else if ($map == 'SNIPPET_5') {
            $field = $prosp->snippet5;
          } else if ($map == 'SNIPPET_6') {
            $field = $prosp->snippet6;
          } else if ($map == 'SNIPPET_7') {
            $field = $prosp->snippet7;
          } else if ($map == 'SNIPPET_8') {
            $field = $prosp->snippet8;
          } else if ($map == 'SNIPPET_9') {
            $field = $prosp->snippet9;
          } else if ($map == 'SNIPPET_10') {
            $field = $prosp->snippet10;
          } else if ($map == 'SNIPPET_11') {
            $field = $prosp->snippet11;
          } else if ($map == 'SNIPPET_12') {
            $field = $prosp->snippet12;
          } else if ($map == 'SNIPPET_13') {
            $field = $prosp->snippet13;
          } else if ($map == 'SNIPPET_14') {
            $field = $prosp->snippet14;
          } else if ($map == 'SNIPPET_15') {
            $field = $prosp->snippet15;
          } else if ($map == 'TITLE') {
            $field = $prosp->title;
          } else if ($map == 'PHONE') {
            $field = $prosp->phone;
          } else if ($map == 'ADDRESS') {
            $field = $prosp->address;
          } else if ($map == 'CITY') {
            $field = $prosp->city;
          } else if ($map == 'LINKEDIN_URL') {
            $field = $prosp->linkedin_url;
          } else if ($map == 'STATE') {
            $field = $prosp->state;
          } else if ($map == 'COUNTRY') {
            $field = $prosp->country;
          } else if ($map == 'INDUSTRY') {
            $field = $prosp->industry;
          }

          $additionalCol .= '<div class="row-table"><span class="row-table__text" onmouseover="showTooltipForEllipsis(this, \'' . $field . '\')" onmouseout="removeTooltip()">' . (empty($field) ? '—' : $field) . '</span></div>';
        }
      }

    $additionalCol .= '</div>';
  endforeach;
?>
  <div class="col-container">
    <div class="col-container__margin">
      <div class="prospect-content">
        <h5 class="uppercase"><?php _e('Prospects from woodpecker for WordPress', $this->plugin_name); ?></h5>
        <?php if (!empty($emailCol) || (empty($emailCol) && !empty($urlBuilder->getCurlUrl()))) : ?>
          <section class="filter-panel">
            <input type="text" id="searchBox" value="" placeholder="search..." style="display: none;">
            <span style="display: none;"><?php _e('or', $this->plugin_name); ?></span>
            <span style="margin-left: 0;"><?php _e('filter by:', $this->plugin_name); ?></span>
            <span class="linkLabel" onclick="openPopupTooltip('status', this)"><?php _e('status', $this->plugin_name); ?></span>
            <div id="popupTooltipStatus" class="popupTooltip">
              <div class="popupTooltip__arrow">
                <div class="arrow-l"></div>
                <div class="arrow-r"></div>
              </div>
              <div class="popupTooltip__content">
                <a href="<?php _e($urlBuilder->getUrlWith('status', 'ACTIVE')); ?>" class="popupTooltip__content--item">
                  <div class="popupTooltip__content--item__text">
                    <?php _e('ACTIVE', $this->plugin_name); ?>
                  </div>
                </a>
                <a href="<?php _e($urlBuilder->getUrlWith('status', 'BOUNCED')); ?>" class="popupTooltip__content--item">
                  <div class="popupTooltip__content--item__text">
                    <?php _e('BOUNCED', $this->plugin_name); ?>
                  </div>
                </a>
                <a href="<?php _e($urlBuilder->getUrlWith('status', 'REPLIED')); ?>" class="popupTooltip__content--item">
                  <div class="popupTooltip__content--item__text">
                    <?php _e('REPLIED', $this->plugin_name); ?>
                  </div>
                </a>
                <a href="<?php _e($urlBuilder->getUrlWith('status', 'BLACKLIST')); ?>" class="popupTooltip__content--item">
                  <div class="popupTooltip__content--item__text">
                    <?php _e('BLACKLIST', $this->plugin_name); ?>
                  </div>
                </a>
                <a href="<?php _e($urlBuilder->getUrlWith('status', 'INVALID')); ?>" class="popupTooltip__content--item">
                  <div class="popupTooltip__content--item__text">
                    <?php _e('INVALID', $this->plugin_name); ?>
                  </div>
                </a>
              </div>
            </div>
          </section>

          <section class="tags-panel">
            <?php echo $urlBuilder->getFilters(); ?>
          </section>

          <section class="empty-filter-panel">
            <div class="empty-filter-panel__img"></div>
            <div class="empty-filter-panel__empty">
              <?php _e("Can't find what you're looking for", $this->plugin_name); ?><br>
              <a href="<?php echo $url; ?>"><div class="empty-filter-panel__btn"><?php _e("Clear all filters", $this->plugin_name); ?></div></a>
            </div>
          </section>

          <section class="prospect-content__table">
            <?php
              $current_url = "//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            ?>

            <div class="prospect-content__table--content">
              <?php
                echo '<div class="prospect-content__table--email"><div class="prospect-content__table--head title fontDemi">' . __('Email', $this->plugin_name) . '</div>' . $emailCol . '</div>';
                echo '<div class="prospect-content__table--scrollable default-skin">' . $header . $additionalCol . '</div>';
              ?>
            </div>
          </section>
          <section class="pagination-section">
            <?php _e('Show rows:', $this->plugin_name); ?>
            <div class="pagination-section__dropdown">
              <span class="pagination-section__rows" onclick="openDropdown(this, 0)"><?php _e($perPage); ?></span>
              <div class="pagination-section__rows--block" style="display: none;">
                <a href="<?php echo $url . '&per_page=10'; ?>">10</a>
                <a href="<?php echo $url . '&per_page=14'; ?>">25</a>
                <a href="<?php echo $url . '&per_page=50'; ?>">50</a>
                <a href="<?php echo $url . '&per_page=100'; ?>">100</a>
                <a href="<?php echo $url . '&per_page=250'; ?>">250</a>
                <a href="<?php echo $url . '&per_page=500'; ?>">500</a>
              </div>
            </div>
            <?php _e('Go to page: ', $this->plugin_name); ?>
            <input type="text" id="page" onkeydown="return ( event.ctrlKey || event.altKey
                      || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)
                      || (95<event.keyCode && event.keyCode<106)
                      || (event.keyCode==8) || (event.keyCode==9)
                      || (event.keyCode>34 && event.keyCode<40)
                      || (event.keyCode==46) )" value="<?php _e($page); ?>"/>
            <div class="pagination-section__max-pages">
            <?php _e('out of', $this->plugin_name); ?>
            <?php
              $maxPage = ceil($getconnectprospects->getTotalCount() / $perPage);
              echo $maxPage;
            ?>
            </div>
            <div class="pagination-section__direct">
              <?php
                $prev = $page - 1;
                $next = $page + 1;

                if ($prev < 1) :
                  echo '<span class="first disabled">First</span>
                      <span class="page-sep"></span>
                      <span class="prev disabled"></span>';
                else :
                  echo '<a href="' . $current_url . '&pageApi=1" class="first">First</a>
                      <span class="page-sep"></span>
                      <a href="' . $current_url . '&pageApi=' . $prev . '" class="prev"></a> ';
                endif;

                $how = (int)($page * $perPage) - ($perPage - 1);
                $count = $page * $perPage;

                if ($page >= $maxPage && $getconnectprospects->getTotalCount() < $count) :
                  $count = $getconnectprospects->getTotalCount();
                endif;

                echo '<div class="pagination-section__direct--current-pages">' . $how . '-' . $count . ' of ' . $getconnectprospects->getTotalCount() . '</div>';

                if($page >= $maxPage) :
                  echo '<span class="next disabled"></span>
                      <span class="page-sep"></span>
                      <span class="last disabled">Last</span>';
                else :
                  echo '<a href="' . $current_url . '&pageApi=' . $next . '" class="next"></a>
                      <span class="page-sep"></span>
                      <a href="' . $current_url . '&pageApi=' . $maxPage . '" class="last">Last</a>';
                endif;
              ?>
              <input value="<?php _e($maxPage); ?>" id="lastPage" type="hidden">
              <input value="<?php _e($current_url . '&pageApi='); ?>" id="redirectUrl" type="hidden">
            </div>
          </section>
          <script type="text/javascript">
            <?php
              if(empty($emailCol)) :
                echo "jQuery('.empty-filter-panel').addClass('show');
                    jQuery('.pagination-section').hide();
                    jQuery('.prospect-content__table').hide();";
              else:
                echo "jQuery('.empty-filter-panel').removeClass('show');
                    jQuery('.pagination-section').show();
                    jQuery('.prospect-content__table').show();";
              endif;
            ?>
          </script>
          <script type="text/javascript" src="<?php _e(plugin_dir_url( __FILE__ )); ?>../js/wfw-prospects.min.js?ver=2.1"></script>
          <script type="text/javascript" src="<?php _e(plugin_dir_url( __FILE__ )); ?>../js/scrollbar.min.js"></script>
        <?php else: ?>
          <section class="no-elements">
            <div class="no-elements__text">
              <?php _e('You have no prospects yet!', $this->plugin_name); ?>
              <br>
              <span class="no-elements__text--small">
                <?php _e('It seems that you have no prospects collected via Woodpecker for Wordpress plugin yet.', $this->plugin_name); ?>
              </span>
              <br>
            </div>
          </section>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php
endif;
?>
