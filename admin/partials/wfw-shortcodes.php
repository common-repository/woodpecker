<?php
/**
 * Admin backend for Shordcodes
 *
 * @link       #
 * @since      1.0.0
 * @author     Woodpecker Team
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/admin/partials
 */

if (!defined('Woodpecker_For_Wordpress_Connector_Admin')) {
    die('Direct access not permitted');
}

$url = '?page=wfw&tab=campaigns';
$page = 1;
$perPage = 10;
$row = 1;

?>
<div class="col-container">
  <div class="col-container__margin">
  <div class="shortcodes-content">
    <?php
      global $wpdb;

      $data = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");
      $getconnectcampaign = new Woodpecker_For_Wordpress_Connector_Curl('/rest/v1/campaign_list', $data->api_key);

      $shortcode = "woodpecker-connector";
      $getjsoncampaign = $getconnectcampaign->getJson();
      $getstatus = $getjsoncampaign->status;
      if ($getstatus->status != 'ERROR' && $data->api_key != '') {
          $view = "";
          $sendFromList = array();
          $code = "";
          foreach ((array)$getjsoncampaign as $camp) :
            if (!empty(trim($camp->from_email))) :
              array_push($sendFromList, $camp->from_email);
            endif;

            if ($row >= 11) :
              $code = 'style="display: none;"';
            endif;

            $view .= '
            <div class="shortcodes-content__table--row__content--row" ' . $code . '>
              <div class="row-table">
                <div class="icon">
                        <div class="icon_' . strtolower(strip_tags($camp->status)) . '"></div>
                        <div class="status icon_text">' . strip_tags($camp->status) . '</div>
                      </div>
              </div>
              <div class="row-table fontDemi"><span class="row-table__text" onmouseover="showTooltipForEllipsis(this, \'' . strip_tags($camp->name) . '\')" onmouseout="removeTooltip()">' . strip_tags($camp->name) . '</span></div>
              <div class="row-table"><span class="send_from row-table__text" onmouseover="showTooltipForEllipsis(this, \'' . strip_tags($camp->from_email) . '\')" onmouseout="removeTooltip()">' . (empty($camp->from_email) ? '—' : strip_tags($camp->from_email)) . '</span></div>
              <div class="row-table fontDemi"><span class="row-table__text arial" onmouseover="showTooltipForEllipsis(this, \'[' . $shortcode . ' id=' . strip_tags($camp->id) . ']\')" onmouseout="removeTooltip()">[' . $shortcode . ' id=' . strip_tags($camp->id) . ']</span><span class="copied-text" style="display: none;">copied</span></div>
              <div class="row-table"><span class="row-table__code" onmouseover="showTooltip(this, \'copy shortcode\')" onmouseout="removeTooltip()"> <input class="code-input" value="[' . $shortcode . ' id=' . strip_tags($camp->id) . ']" type="hidden"></span></div>
            </div>';

            $row++;
          endforeach;

          $sendFromList = array_map("unserialize", array_unique(array_map("serialize", $sendFromList)));
          $row = sizeof($getjsoncampaign);
    ?>
    <h5><?php _e('Shortcodes allow you to send prospect’s data to chosen Woodpecker destination.<br>You can place multiple forms on your website and use one shortcode per each form.', $this->plugin_name); ?></h5>
    <div class="title"><?php _e('Shortcodes for main prospects list', $this->plugin_name); ?></div>
    <div class="code">[<?php echo $shortcode; ?>] <span class="copied-text" style="display: none;">copied</span><span class="code-copy" onmouseover="showTooltip(this, 'copy shortcode')" onmouseout="removeTooltip()"><input id="main-shortcode-input" value="[<?php echo $shortcode; ?>]" type="hidden"></span></div>
    <div class="title"><?php _e('Shortcodes for campaigns', $this->plugin_name); ?></div>
    <?php if (count($getjsoncampaign) > 0 ) : ?>
      <section class="filter-panel">
        <input type="text" value="" id="searchBox" placeholder="<?php _e('search...', $this->plugin_name); ?>">
        <span><?php _e('or', $this->plugin_name); ?></span>
        <span><?php _e('filter by:', $this->plugin_name); ?></span>
        <span class="linkLabel" onclick="openPopupTooltip('campaign_status', this)"><?php _e('status', $this->plugin_name); ?></span>
        <div id="popupTooltipCampaignStatus" class="popupTooltip" style="display: none; position: absolute;">
          <div class="popupTooltip__arrow">
            <div class="arrow-l"></div>
            <div class="arrow-r"></div>
          </div>
          <div class="popupTooltip__content">
            <div rel="status" class="popupTooltip__content--item"><div class="popupTooltip__content--item__text"><?php _e('RUNNING', $this->plugin_name); ?></div></div>
            <div rel="status" class="popupTooltip__content--item"><div class="popupTooltip__content--item__text"><?php _e('STOPPED', $this->plugin_name); ?></div></div>
            <div rel="status" class="popupTooltip__content--item"><div class="popupTooltip__content--item__text"><?php _e('PAUSED', $this->plugin_name); ?></div></div>
            <div rel="status" class="popupTooltip__content--item"><div class="popupTooltip__content--item__text"><?php _e('DRAFT', $this->plugin_name); ?></div></div>
            <div rel="status" class="popupTooltip__content--item"><div class="popupTooltip__content--item__text"><?php _e('EDITED', $this->plugin_name); ?></div></div>
            <div rel="status" class="popupTooltip__content--item"><div class="popupTooltip__content--item__text"><?php _e('COMPLETED', $this->plugin_name); ?></div></div>
          </div>
        </div>
        <span class="linkLabel" onclick="openPopupTooltip('send_from', this); setScroll('#popupTooltipSendFromContent', '412px');"><?php _e('send from', $this->plugin_name); ?></span>
        <div id="popupTooltipSendFrom" class="popupTooltip" style="display: none; position: absolute;">
          <div class="popupTooltip__arrow">
            <div class="arrow-l"></div>
            <div class="arrow-r"></div>
          </div>
          <div id="popupTooltipSendFromContent" class="popupTooltip__content">
          <?php
            if (sizeof((array)$sendFromList) > 0) :
              foreach ($sendFromList as $key) :
                echo ('<div class="popupTooltip__content--item" rel="send_from"><div class="popupTooltip__content--item__text" onmouseover="showTooltipForEllipsis(this, \'' . strip_tags($key) . '\')" onmouseout="removeTooltip()">' . strip_tags($key) . '</div></div>');
              endforeach;
            else:
          ?>
              <div class="empty">
                <?php  _e('You have no any emails connected with campaigns yet.'); ?>
              </div>
          <?php
            endif;
          ?>
          </div>
        </div>
      </section>

      <section class="tags-panel"></section>

      <section class="empty-filter-panel">
        <div class="empty-filter-panel__img"></div>
        <div class="empty-filter-panel__empty">
          <?php _e("Can't find what you're looking for", $this->plugin_name); ?><br>
          <div class="empty-filter-panel__btn"><?php _e("Clear all filters", $this->plugin_name); ?></div>
        </div>
      </section>

      <section class="shortcodes-content__table">
        <div class="shortcodes-content__table--row title fontDemi">
          <div class="shortcodes-content__table--row__status"><?php _e('Status', $this->plugin_name); ?></div>
          <div class="shortcodes-content__table--row__natural"><?php _e('Campaign name', $this->plugin_name); ?></div>
          <div class="shortcodes-content__table--row__natural"><?php _e('From', $this->plugin_name); ?></div>
          <div class="shortcodes-content__table--row__natural"><?php _e('Shortcode', $this->plugin_name); ?></div>
          <div></div>
        </div>
        <div class="shortcodes-content__table--row__content">
          <?php _e($view); ?>
        </div>
      </section>

      <section class="pagination-section">
        <?php _e('Show rows:', $this->plugin_name); ?>
        <div class="pagination-section__dropdown">
          <span class="pagination-section__rows" onclick="openDropdown(this, '0')">10</span>
          <div class="pagination-section__rows--block" style="display: none;">
            <span class="pagination-section__rows--block__value">10</span>
            <span class="pagination-section__rows--block__value">25</span>
            <span class="pagination-section__rows--block__value">50</span>
            <span class="pagination-section__rows--block__value">100</span>
            <span class="pagination-section__rows--block__value">250</span>
            <span class="pagination-section__rows--block__value">500</span>
          </div>
        </div>
        <?php _e('Go to page: ', $this->plugin_name); ?>
        <input type="text" id="page" onkeydown="return ( event.ctrlKey || event.altKey
                        || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)
                        || (95<event.keyCode && event.keyCode<106)
                        || (event.keyCode==8) || (event.keyCode==9)
                        || (event.keyCode>34 && event.keyCode<40)
                        || (event.keyCode==46) )" value="1"/>
        <div class="pagination-section__max-pages">
          <?php
            _e('out of ', $this->plugin_name);
            _e(ceil($row / $perPage));
          ?>
        </div>
        <div class="pagination-section__direct">
          <span class="first disabled"><?php _e('First', $this->plugin_name); ?></span>
          <span class="page-sep"></span>
          <span class="prev disabled"></span>
          <div class="pagination-section__direct--current-pages">1-<?php _e($perPage); ?>
            <?php
              _e(' of ', $this->plugin_name);
              _e($row);
            ?>
          </div>
          <span class="next"></span>
          <span class="page-sep"></span>
          <span class="last"><?php _e('Last', $this->plugin_name); ?></span>
        </div>
      </section>

      <input id="perPage" value="10" type="hidden">
      <input id="howElement" value="<?php _e($row); ?>"  type="hidden">

  <?php else: ?>
    <section class="no-elements">
      <div class="no-elements__text">
        You have no campaigns yet!<br>
        <span class="no-elements__text--small">To use shortcodes go to your Woodpecker account and <a href="https://app.woodpecker.co" target="_blank">create campaigns</a>.</span><br>
      </div>
    </section>
  <?php endif; ?>
<?php } else { ?>
  <section class="no-elements">
    <div class="no-elements__text">
      You have no campaigns yet!<br>
      <span class="no-elements__text--small">To use shortcodes go to your Woodpecker account and <a href="https://app.woodpecker.co" target="_blank">create campaigns</a>.</span><br>
    </div>
  </section>
<?php } ?>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php _e(plugin_dir_url( __FILE__ )); ?>../js/wfw-shortcodes.min.js?ver=2.1"></script>
<script type="text/javascript" src="<?php _e(plugin_dir_url( __FILE__ )); ?>../js/slimscroll.min.js"></script>
