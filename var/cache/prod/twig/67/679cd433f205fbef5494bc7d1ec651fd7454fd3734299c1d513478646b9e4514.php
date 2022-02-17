<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* __string_template__808be23115de70f4ef16f1c5acbaa5cebd725956c8a7f95623cf8977970107aa */
class __TwigTemplate_8f93727a9b9c75bf0d6a6365ed40a21c1dadfdadc19fb59e3bf39aff6fe618c9 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'extra_stylesheets' => [$this, 'block_extra_stylesheets'],
            'content_header' => [$this, 'block_content_header'],
            'content' => [$this, 'block_content'],
            'content_footer' => [$this, 'block_content_footer'],
            'sidebar_right' => [$this, 'block_sidebar_right'],
            'javascripts' => [$this, 'block_javascripts'],
            'extra_javascripts' => [$this, 'block_extra_javascripts'],
            'translate_javascripts' => [$this, 'block_translate_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
<meta name=\"robots\" content=\"NOFOLLOW, NOINDEX\">

<link rel=\"icon\" type=\"image/x-icon\" href=\"/ytc_templates/prestashop/sp_topdeals_1770/img/favicon.ico\" />
<link rel=\"apple-touch-icon\" href=\"/ytc_templates/prestashop/sp_topdeals_1770/img/app_icon.png\" />

<title>Performance • SP Topdeals</title>

  <script type=\"text/javascript\">
    var help_class_name = 'AdminPerformance';
    var iso_user = 'en';
    var lang_is_rtl = '0';
    var full_language_code = 'en-us';
    var full_cldr_language_code = 'en-US';
    var country_iso_code = 'US';
    var _PS_VERSION_ = '1.7.7.0';
    var roundMode = 2;
    var youEditFieldFor = '';
        var new_order_msg = 'A new order has been placed on your shop.';
    var order_number_msg = 'Order number: ';
    var total_msg = 'Total: ';
    var from_msg = 'From: ';
    var see_order_msg = 'View this order';
    var new_customer_msg = 'A new customer registered on your shop.';
    var customer_name_msg = 'Customer name: ';
    var new_msg = 'A new message was posted on your shop.';
    var see_msg = 'Read this message';
    var token = 'ca552f2faa86bf7d221926a2d291a642';
    var token_admin_orders = 'c8c38bb0efa3ca22d028aaeff9b07b8a';
    var token_admin_customers = '22b9c24cce44bca17d5b4abb9c6b66b4';
    var token_admin_customer_threads = 'ae44ff2d1cbcac75e639d3e020c6b3f9';
    var currentIndex = 'index.php?controller=AdminPerformance';
    var employee_token = '61030b47d0e6ab33d051fe239a9f5bce';
    var choose_language_translate = 'Choose language:';
    var default_language = '1';
    var admin_modules_link = '/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/modules/catalog/recommended?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs';
    var admin_notification_get_link = '/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/common/notifications?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs';
    var admin_notification_push_link = '/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/common/notifications/ack?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs';
    var tab_modules_list = '';
    var update_success_msg = 'Update successful';
    var errorLogin = 'PrestaShop was unable to log in to Addons. Please check your credentials and your Internet connection.';
    var search_product_msg = 'Search for a product';
  </script>

      <link href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/themes/new-theme/public/theme.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/ytc_templates/prestashop/sp_topdeals_1770/js/jquery/plugins/chosen/jquery.chosen.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/ytc_templates/prestashop/sp_topdeals_1770/js/jquery/plugins/fancybox/jquery.fancybox.css\" rel=\"stylesheet\" type=\"text/css\"/>
  
  <script type=\"text/javascript\">
var baseAdminDir = \"\\/ytc_templates\\/prestashop\\/sp_topdeals_1770\\/sp_admin\\/\";
var baseDir = \"\\/ytc_templates\\/prestashop\\/sp_topdeals_1770\\/\";
var changeFormLanguageUrl = \"\\/ytc_templates\\/prestashop\\/sp_topdeals_1770\\/sp_admin\\/index.php\\/configure\\/advanced\\/employees\\/change-form-language?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\";
var currency = {\"iso_code\":\"USD\",\"sign\":\"\$\",\"name\":\"US Dollar\",\"format\":null};
var currency_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"currencyCode\":\"USD\",\"currencySymbol\":\"\$\",\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"\\u00a4#,##0.00\",\"negativePattern\":\"-\\u00a4#,##0.00\",\"maxFractionDigits\":2,\"minFractionDigits\":2,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var host_mode = false;
var number_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"#,##0.###\",\"negativePattern\":\"-#,##0.###\",\"maxFractionDigits\":3,\"minFractionDigits\":0,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var prestashop = {\"debug\":false};
var show_new_customers = \"1\";
var show_new_messages = false;
var show_new_orders = \"1\";
</script>
<script type=\"text/javascript\" src=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/themes/new-theme/public/main.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/ytc_templates/prestashop/sp_topdeals_1770/js/jquery/plugins/jquery.chosen.js\"></script>
<script type=\"text/javascript\" src=\"/ytc_templates/prestashop/sp_topdeals_1770/js/jquery/plugins/fancybox/jquery.fancybox.js\"></script>
<script type=\"text/javascript\" src=\"/ytc_templates/prestashop/sp_topdeals_1770/js/admin.js?v=1.7.7.0\"></script>
<script type=\"text/javascript\" src=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/themes/new-theme/public/cldr.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/ytc_templates/prestashop/sp_topdeals_1770/js/tools.js?v=1.7.7.0\"></script>
<script type=\"text/javascript\" src=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/public/bundle.js\"></script>

  <style>
.icon-AdminSmartBlog:before{
  content: \"\\f14b\";
   }
 
</style>

";
        // line 82
        $this->displayBlock('stylesheets', $context, $blocks);
        $this->displayBlock('extra_stylesheets', $context, $blocks);
        echo "</head>

<body
  class=\"lang-en adminperformance\"
  data-base-url=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php\"  data-token=\"RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\">

  <header id=\"header\" class=\"d-print-none\">

    <nav id=\"header_infos\" class=\"main-header\">
      <button class=\"btn btn-primary-reverse onclick btn-lg unbind ajax-spinner\"></button>

            <i class=\"material-icons js-mobile-menu\">menu</i>
      <a id=\"header_logo\" class=\"logo float-left\" href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminDashboard&amp;token=6a9ee1277b9c14c3fc2f5aa274dbaeb5\"></a>
      <span id=\"shop_version\">1.7.7.0</span>

      <div class=\"component\" id=\"quick-access-container\">
        <div class=\"dropdown quick-accesses\">
  <button class=\"btn btn-link btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id=\"quick_select\">
    Quick Access
  </button>
  <div class=\"dropdown-menu\">
          <a class=\"dropdown-item\"
         href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminStats&amp;module=statscheckup&amp;token=aef19b288e1a37c0f175f96db0f43795\"
                 data-item=\"Catalog evaluation\"
      >Catalog evaluation</a>
          <a class=\"dropdown-item\"
         href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminStats&amp;module=statscheckup&amp;token=aef19b288e1a37c0f175f96db0f43795\"
                 data-item=\"Catalog evaluation\"
      >Catalog evaluation</a>
          <a class=\"dropdown-item\"
         href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/modules/manage?token=8fb279e24a6b2967fa04b2c91672b2ca\"
                 data-item=\"Installed modules\"
      >Installed modules</a>
          <a class=\"dropdown-item\"
         href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCategories&amp;addcategory&amp;token=aaf2f3bf03251a17c7a51b0ee90de69a\"
                 data-item=\"New category\"
      >New category</a>
          <a class=\"dropdown-item\"
         href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/catalog/products/new?token=8fb279e24a6b2967fa04b2c91672b2ca\"
                 data-item=\"New product\"
      >New product</a>
          <a class=\"dropdown-item\"
         href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCartRules&amp;addcart_rule&amp;token=366f1badca9160dc5c23bd0f2c1e8091\"
                 data-item=\"New voucher\"
      >New voucher</a>
          <a class=\"dropdown-item\"
         href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminOrders&amp;token=c8c38bb0efa3ca22d028aaeff9b07b8a\"
                 data-item=\"Orders\"
      >Orders</a>
          <a class=\"dropdown-item\"
         href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminModules&amp;&amp;configure=smartblog&amp;token=f5f32647cfb64e4c35d1e6d1dc08e2ce\"
                 data-item=\"Smart Blog Setting\"
      >Smart Blog Setting</a>
        <div class=\"dropdown-divider\"></div>
          <a
        class=\"dropdown-item js-quick-link\"
        href=\"#\"
        data-rand=\"170\"
        data-icon=\"icon-AdminAdvancedParameters\"
        data-method=\"add\"
        data-url=\"index.php/configure/advanced/performance/?-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\"
        data-post-link=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminQuickAccesses&token=35f205e0011251f360af279c56b6e496\"
        data-prompt-text=\"Please name this shortcut:\"
        data-link=\"Performance - List\"
      >
        <i class=\"material-icons\">add_circle</i>
        Add current page to Quick Access
      </a>
        <a class=\"dropdown-item\" href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminQuickAccesses&token=35f205e0011251f360af279c56b6e496\">
      <i class=\"material-icons\">settings</i>
      Manage your quick accesses
    </a>
  </div>
</div>
      </div>
      <div class=\"component\" id=\"header-search-container\">
        <form id=\"header_search\"
      class=\"bo_search_form dropdown-form js-dropdown-form collapsed\"
      method=\"post\"
      action=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminSearch&amp;token=a76aabab78c7d31a0076fa092ef22c92\"
      role=\"search\">
  <input type=\"hidden\" name=\"bo_search_type\" id=\"bo_search_type\" class=\"js-search-type\" />
    <div class=\"input-group\">
    <input type=\"text\" class=\"form-control js-form-search\" id=\"bo_query\" name=\"bo_query\" value=\"\" placeholder=\"Search (e.g.: product reference, customer name…) d='Admin.Navigation.Header'\">
    <div class=\"input-group-append\">
      <button type=\"button\" class=\"btn btn-outline-secondary dropdown-toggle js-dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        Everywhere
      </button>
      <div class=\"dropdown-menu js-items-list\">
        <a class=\"dropdown-item\" data-item=\"Everywhere\" href=\"#\" data-value=\"0\" data-placeholder=\"What are you looking for?\" data-icon=\"icon-search\"><i class=\"material-icons\">search</i> Everywhere</a>
        <div class=\"dropdown-divider\"></div>
        <a class=\"dropdown-item\" data-item=\"Catalog\" href=\"#\" data-value=\"1\" data-placeholder=\"Product name, reference, etc.\" data-icon=\"icon-book\"><i class=\"material-icons\">store_mall_directory</i> Catalog</a>
        <a class=\"dropdown-item\" data-item=\"Customers by name\" href=\"#\" data-value=\"2\" data-placeholder=\"Name\" data-icon=\"icon-group\"><i class=\"material-icons\">group</i> Customers by name</a>
        <a class=\"dropdown-item\" data-item=\"Customers by ip address\" href=\"#\" data-value=\"6\" data-placeholder=\"123.45.67.89\" data-icon=\"icon-desktop\"><i class=\"material-icons\">desktop_mac</i> Customers by IP address</a>
        <a class=\"dropdown-item\" data-item=\"Orders\" href=\"#\" data-value=\"3\" data-placeholder=\"Order ID\" data-icon=\"icon-credit-card\"><i class=\"material-icons\">shopping_basket</i> Orders</a>
        <a class=\"dropdown-item\" data-item=\"Invoices\" href=\"#\" data-value=\"4\" data-placeholder=\"Invoice number\" data-icon=\"icon-book\"><i class=\"material-icons\">book</i> Invoices</a>
        <a class=\"dropdown-item\" data-item=\"Carts\" href=\"#\" data-value=\"5\" data-placeholder=\"Cart ID\" data-icon=\"icon-shopping-cart\"><i class=\"material-icons\">shopping_cart</i> Carts</a>
        <a class=\"dropdown-item\" data-item=\"Modules\" href=\"#\" data-value=\"7\" data-placeholder=\"Module name\" data-icon=\"icon-puzzle-piece\"><i class=\"material-icons\">extension</i> Modules</a>
      </div>
      <button class=\"btn btn-primary\" type=\"submit\"><span class=\"d-none\">SEARCH</span><i class=\"material-icons\">search</i></button>
    </div>
  </div>
</form>

<script type=\"text/javascript\">
 \$(document).ready(function(){
    \$('#bo_query').one('click', function() {
    \$(this).closest('form').removeClass('collapsed');
  });
});
</script>
      </div>

      
      
      <div class=\"component\" id=\"header-shop-list-container\">
          <div class=\"shop-list\">
    <a class=\"link\" id=\"header_shopname\" href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/\" target= \"_blank\">
      <i class=\"material-icons\">visibility</i>
      View my shop
    </a>
  </div>
      </div>

              <div class=\"component header-right-component\" id=\"header-notifications-container\">
          <div id=\"notif\" class=\"notification-center dropdown dropdown-clickable\">
  <button class=\"btn notification js-notification dropdown-toggle\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">notifications_none</i>
    <span id=\"notifications-total\" class=\"count hide\">0</span>
  </button>
  <div class=\"dropdown-menu dropdown-menu-right js-notifs_dropdown\">
    <div class=\"notifications\">
      <ul class=\"nav nav-tabs\" role=\"tablist\">
                          <li class=\"nav-item\">
            <a
              class=\"nav-link active\"
              id=\"orders-tab\"
              data-toggle=\"tab\"
              data-type=\"order\"
              href=\"#orders-notifications\"
              role=\"tab\"
            >
              Orders<span id=\"_nb_new_orders_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"customers-tab\"
              data-toggle=\"tab\"
              data-type=\"customer\"
              href=\"#customers-notifications\"
              role=\"tab\"
            >
              Customers<span id=\"_nb_new_customers_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"messages-tab\"
              data-toggle=\"tab\"
              data-type=\"customer_message\"
              href=\"#messages-notifications\"
              role=\"tab\"
            >
              Messages<span id=\"_nb_new_messages_\"></span>
            </a>
          </li>
                        </ul>

      <!-- Tab panes -->
      <div class=\"tab-content\">
                          <div class=\"tab-pane active empty\" id=\"orders-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              No new order for now :(<br>
              Have you checked your <strong><a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCarts&action=filterOnlyAbandonedCarts&token=8e3dae2a84db87f6c81a0e660570be2d\">abandoned carts</a></strong>?<br>Your next order could be hiding there!
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"customers-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              No new customer for now :(<br>
              Have you considered selling on marketplaces?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"messages-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              No new message for now.<br>
              No news is good news, isn't it?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                        </div>
    </div>
  </div>
</div>

  <script type=\"text/html\" id=\"order-notification-template\">
    <a class=\"notif\" href='order_url'>
      #_id_order_ -
      from <strong>_customer_name_</strong> (_iso_code_)_carrier_
      <strong class=\"float-sm-right\">_total_paid_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"customer-notification-template\">
    <a class=\"notif\" href='customer_url'>
      #_id_customer_ - <strong>_customer_name_</strong>_company_ - registered <strong>_date_add_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"message-notification-template\">
    <a class=\"notif\" href='message_url'>
    <span class=\"message-notification-status _status_\">
      <i class=\"material-icons\">fiber_manual_record</i> _status_
    </span>
      - <strong>_customer_name_</strong> (_company_) - <i class=\"material-icons\">access_time</i> _date_add_
    </a>
  </script>
        </div>
      
      <div class=\"component\" id=\"header-employee-container\">
        <div class=\"dropdown employee-dropdown\">
  <div class=\"rounded-circle person\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">account_circle</i>
  </div>
  <div class=\"dropdown-menu dropdown-menu-right\">
    <div class=\"employee-wrapper-avatar\">
      
      <span class=\"employee_avatar\"><img class=\"avatar rounded-circle\" src=\"http://profile.prestashop.com/themes%40magentech.com.jpg\" /></span>
      <span class=\"employee_profile\">Welcome back Magen</span>
      <a class=\"dropdown-item employee-link profile-link\" href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/employees/1/edit?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\">
      <i class=\"material-icons\">settings</i>
      Your profile
    </a>
    </div>
    
    <p class=\"divider\"></p>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/resources/documentations?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">book</i> Resources</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/training?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=training-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">school</i> Training</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/experts?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=expert-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">person_pin_circle</i> Find an Expert</a>
    <a class=\"dropdown-item\" href=\"https://addons.prestashop.com?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=addons-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">extension</i> PrestaShop Marketplace</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/contact?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=help-center-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">help</i> Help Center</a>
    <p class=\"divider\"></p>
    <a class=\"dropdown-item employee-link text-center\" id=\"header_logout\" href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminLogin&amp;logout=1&amp;token=15f36128e1282635572fb35dad48888c\">
      <i class=\"material-icons d-lg-none\">power_settings_new</i>
      <span>Sign out</span>
    </a>
  </div>
</div>
      </div>
          </nav>
  </header>

  <nav class=\"nav-bar d-none d-print-none d-md-block\">
  <span class=\"menu-collapse\" data-toggle-url=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/employees/toggle-navigation?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\">
    <i class=\"material-icons\">chevron_left</i>
    <i class=\"material-icons\">chevron_left</i>
  </span>

  <div class=\"nav-bar-overflow\">
    <ul class=\"main-menu\">
              
                    
                    
          
            <li class=\"link-levelone \" data-submenu=\"1\" id=\"tab-AdminDashboard\">
              <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminDashboard&amp;token=6a9ee1277b9c14c3fc2f5aa274dbaeb5\" class=\"link\" >
                <i class=\"material-icons\">trending_up</i> <span>Dashboard</span>
              </a>
            </li>

          
                      
                                          
                    
          
            <li class=\"category-title \" data-submenu=\"2\" id=\"tab-SELL\">
                <span class=\"title\">Sell</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"3\" id=\"subtab-AdminParentOrders\">
                    <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/orders/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\">
                      <i class=\"material-icons mi-shopping_basket\">shopping_basket</i>
                      <span>
                      Orders
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-3\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"4\" id=\"subtab-AdminOrders\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/orders/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Orders
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"5\" id=\"subtab-AdminInvoices\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/orders/invoices/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Invoices
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"6\" id=\"subtab-AdminSlip\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/orders/credit-slips/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Credit Slips
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"7\" id=\"subtab-AdminDeliverySlip\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/orders/delivery-slips/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Delivery Slips
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"8\" id=\"subtab-AdminCarts\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCarts&amp;token=8e3dae2a84db87f6c81a0e660570be2d\" class=\"link\"> Shopping Carts
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"9\" id=\"subtab-AdminCatalog\">
                    <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/catalog/products?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\">
                      <i class=\"material-icons mi-store\">store</i>
                      <span>
                      Catalog
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-9\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"10\" id=\"subtab-AdminProducts\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/catalog/products?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Products
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"11\" id=\"subtab-AdminCategories\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/catalog/categories?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Categories
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"12\" id=\"subtab-AdminTracking\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/catalog/monitoring/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Monitoring
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"13\" id=\"subtab-AdminParentAttributesGroups\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminAttributesGroups&amp;token=eb03f9a0ed36c2e5496e47395c25f1f8\" class=\"link\"> Attributes &amp; Features
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"16\" id=\"subtab-AdminParentManufacturers\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/catalog/brands/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Brands &amp; Suppliers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"19\" id=\"subtab-AdminAttachments\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/attachments/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Files
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"20\" id=\"subtab-AdminParentCartRules\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCartRules&amp;token=366f1badca9160dc5c23bd0f2c1e8091\" class=\"link\"> Discounts
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"129\" id=\"subtab-AdminStockManagement\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/stocks/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Stock
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"23\" id=\"subtab-AdminParentCustomer\">
                    <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/customers/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\">
                      <i class=\"material-icons mi-account_circle\">account_circle</i>
                      <span>
                      Customers
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-23\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"24\" id=\"subtab-AdminCustomers\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/customers/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Customers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"25\" id=\"subtab-AdminAddresses\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/addresses/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Addresses
                                </a>
                              </li>

                                                                                                                                    </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"27\" id=\"subtab-AdminParentCustomerThreads\">
                    <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCustomerThreads&amp;token=ae44ff2d1cbcac75e639d3e020c6b3f9\" class=\"link\">
                      <i class=\"material-icons mi-chat\">chat</i>
                      <span>
                      Customer Service
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-27\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"28\" id=\"subtab-AdminCustomerThreads\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCustomerThreads&amp;token=ae44ff2d1cbcac75e639d3e020c6b3f9\" class=\"link\"> Customer Service
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"29\" id=\"subtab-AdminOrderMessage\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/sell/customer-service/order-messages/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Order Messages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"30\" id=\"subtab-AdminReturn\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminReturn&amp;token=62bf985052e39392c69ecb9d66c51c1a\" class=\"link\"> Merchandise Returns
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"31\" id=\"subtab-AdminStats\">
                    <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminStats&amp;token=aef19b288e1a37c0f175f96db0f43795\" class=\"link\">
                      <i class=\"material-icons mi-assessment\">assessment</i>
                      <span>
                      Stats
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title \" data-submenu=\"41\" id=\"tab-IMPROVE\">
                <span class=\"title\">Improve</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"42\" id=\"subtab-AdminParentModulesSf\">
                    <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/modules/manage?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Modules
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-42\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"43\" id=\"subtab-AdminModulesSf\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/modules/manage?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Module Manager
                                </a>
                              </li>

                                                                                                                                        
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"150\" id=\"subtab-AdminParentModulesCatalog\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/modules/catalog?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Module Catalog
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"46\" id=\"subtab-AdminParentThemes\">
                    <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/design/themes/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\">
                      <i class=\"material-icons mi-desktop_mac\">desktop_mac</i>
                      <span>
                      Design
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-46\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"47\" id=\"subtab-AdminThemes\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/design/themes/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Theme &amp; Logo
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"48\" id=\"subtab-AdminThemesCatalog\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/design/themes-catalog/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Theme Catalog
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"187\" id=\"subtab-AdminParentMailTheme\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/design/mail_theme/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Email Themes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"49\" id=\"subtab-AdminCmsContent\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/design/cms-pages/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Pages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"50\" id=\"subtab-AdminModulesPositions\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/design/modules/positions/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Positions
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"51\" id=\"subtab-AdminImages\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminImages&amp;token=85f870fef6ad0cf89b31590acc7dace7\" class=\"link\"> Image Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"116\" id=\"subtab-AdminLinkWidget\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminLinkWidget&amp;token=b5b957b5c3bacc28bec168584cfc6b68\" class=\"link\"> Link Widget
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"52\" id=\"subtab-AdminParentShipping\">
                    <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCarriers&amp;token=b13d78392fad39165c3bead6cf42ce74\" class=\"link\">
                      <i class=\"material-icons mi-local_shipping\">local_shipping</i>
                      <span>
                      Shipping
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-52\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"53\" id=\"subtab-AdminCarriers\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCarriers&amp;token=b13d78392fad39165c3bead6cf42ce74\" class=\"link\"> Carriers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"54\" id=\"subtab-AdminShipping\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/shipping/preferences?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Preferences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"55\" id=\"subtab-AdminParentPayment\">
                    <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/payment/payment_methods?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\">
                      <i class=\"material-icons mi-payment\">payment</i>
                      <span>
                      Payment
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-55\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"56\" id=\"subtab-AdminPayment\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/payment/payment_methods?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Payment Methods
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"57\" id=\"subtab-AdminPaymentPreferences\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/payment/preferences?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Preferences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"58\" id=\"subtab-AdminInternational\">
                    <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/international/localization/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\">
                      <i class=\"material-icons mi-language\">language</i>
                      <span>
                      International
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-58\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"59\" id=\"subtab-AdminParentLocalization\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/international/localization/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Localization
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"64\" id=\"subtab-AdminParentCountries\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminCountries&amp;token=38ea8dcc9dc7a2d0f497832524646714\" class=\"link\"> Locations
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"68\" id=\"subtab-AdminParentTaxes\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/international/taxes/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Taxes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"71\" id=\"subtab-AdminTranslations\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/improve/international/translations/settings?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Translations
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title -active\" data-submenu=\"72\" id=\"tab-CONFIGURE\">
                <span class=\"title\">Configure</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"73\" id=\"subtab-ShopParameters\">
                    <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/shop/preferences/preferences?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\">
                      <i class=\"material-icons mi-settings\">settings</i>
                      <span>
                      Shop Parameters
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-73\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"74\" id=\"subtab-AdminParentPreferences\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/shop/preferences/preferences?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> General
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"77\" id=\"subtab-AdminParentOrderPreferences\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/shop/order-preferences/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Order Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"80\" id=\"subtab-AdminPPreferences\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/shop/product-preferences/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Product Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"81\" id=\"subtab-AdminParentCustomerPreferences\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/shop/customer-preferences/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Customer Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"85\" id=\"subtab-AdminParentStores\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/shop/contacts/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Contact
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"88\" id=\"subtab-AdminParentMeta\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/shop/seo-urls/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Traffic &amp; SEO
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"92\" id=\"subtab-AdminParentSearchConf\">
                                <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminSearchConf&amp;token=2dfcda3ca99fddc62e15a2816b943106\" class=\"link\"> Search
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                                                          
                  <li class=\"link-levelone has_submenu -active open ul-open\" data-submenu=\"95\" id=\"subtab-AdminAdvancedParameters\">
                    <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/system-information/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\">
                      <i class=\"material-icons mi-settings_applications\">settings_applications</i>
                      <span>
                      Advanced Parameters
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_up
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-95\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"96\" id=\"subtab-AdminInformation\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/system-information/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Information
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo -active\" data-submenu=\"97\" id=\"subtab-AdminPerformance\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/performance/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Performance
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"98\" id=\"subtab-AdminAdminPreferences\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/administration/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Administration
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"99\" id=\"subtab-AdminEmails\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/emails/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> E-mail
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"100\" id=\"subtab-AdminImport\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/import/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Import
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"101\" id=\"subtab-AdminParentEmployees\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/employees/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Team
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"105\" id=\"subtab-AdminParentRequestSql\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/sql-requests/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Database
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"108\" id=\"subtab-AdminLogs\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/logs/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Logs
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"109\" id=\"subtab-AdminWebservice\">
                                <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/webservice-keys/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" class=\"link\"> Webservice
                                </a>
                              </li>

                                                                                                                                                                                          </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title \" data-submenu=\"172\" id=\"tab-AdminSmartBlog\">
                <span class=\"title\">Blog</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"173\" id=\"subtab-AdminBlogCategory\">
                    <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminBlogCategory&amp;token=e7d1a3611779e8dec7af57bc1fe7156f\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Blog Category
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"174\" id=\"subtab-AdminBlogcomment\">
                    <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminBlogcomment&amp;token=322579874fc7b86761ec1775bf9c7e74\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Blog Comments
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"175\" id=\"subtab-AdminBlogPost\">
                    <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminBlogPost&amp;token=875a192a72cd7e8904a5681651a4bd90\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Blog Post
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"176\" id=\"subtab-AdminImageType\">
                    <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminImageType&amp;token=06e4cc9e41387cc37fc9261873503bcc\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Image Type
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"177\" id=\"subtab-AdminAboutUs\">
                    <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminAboutUs&amp;token=57c8d79ddccf19b145318acaa9045bf0\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      AboutUs
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title \" data-submenu=\"184\" id=\"tab-AdminSP\">
                <span class=\"title\">MagenTech</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"185\" id=\"subtab-AdminSPConfig\">
                    <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminSPConfig&amp;token=f0fdb498d7a98f3b4c265037b30a7032\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      SP Theme Configuration
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                              
          
                  </ul>
  </div>
  
</nav>

<div id=\"main-div\">
          
<div class=\"header-toolbar d-print-none\">
  <div class=\"container-fluid\">

    
      <nav aria-label=\"Breadcrumb\">
        <ol class=\"breadcrumb\">
                      <li class=\"breadcrumb-item\">Advanced Parameters</li>
          
                      <li class=\"breadcrumb-item active\">
              <a href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/performance/?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\" aria-current=\"page\">Performance</a>
            </li>
                  </ol>
      </nav>
    

    <div class=\"title-row\">
      
          <h1 class=\"title\">
            Performance          </h1>
      

      
        <div class=\"toolbar-icons\">
          <div class=\"wrapper\">
            
                                                          <a
                  class=\"btn btn-primary  pointer\"                  id=\"page-header-desc-configuration-clear_cache\"
                  href=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/configure/advanced/performance/clear-cache?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\"                  title=\"Clear cache\"                >
                  <i class=\"material-icons\">delete</i>                  Clear cache
                </a>
                                      
            
                              <a class=\"btn btn-outline-secondary btn-help btn-sidebar\" href=\"#\"
                   title=\"Help\"
                   data-toggle=\"sidebar\"
                   data-target=\"#right-sidebar\"
                   data-url=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fen%252Fdoc%252FAdminPerformance%253Fversion%253D1.7.7.0%2526country%253Den/Help?_token=RY-7Rrgo3ulzKx8SdrgTCX27TO0olLOKpUf7BI6oNAs\"
                   id=\"product_form_open_help\"
                >
                  Help
                </a>
                                    </div>
        </div>
      
    </div>
  </div>

  
    
</div>
      
      <div class=\"content-div  \">

        

                                                        
        <div class=\"row \">
          <div class=\"col-sm-12\">
            <div id=\"ajax_confirmation\" class=\"alert alert-success\" style=\"display: none;\"></div>


  ";
        // line 1175
        $this->displayBlock('content_header', $context, $blocks);
        // line 1176
        echo "                 ";
        $this->displayBlock('content', $context, $blocks);
        // line 1177
        echo "                 ";
        $this->displayBlock('content_footer', $context, $blocks);
        // line 1178
        echo "                 ";
        $this->displayBlock('sidebar_right', $context, $blocks);
        // line 1179
        echo "
            
          </div>
        </div>

      </div>
    </div>

  <div id=\"non-responsive\" class=\"js-non-responsive\">
  <h1>Oh no!</h1>
  <p class=\"mt-3\">
    The mobile version of this page is not available yet.
  </p>
  <p class=\"mt-2\">
    Please use a desktop computer to access this page, until is adapted to mobile.
  </p>
  <p class=\"mt-2\">
    Thank you.
  </p>
  <a href=\"http://dev.ytcvn.com/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/index.php?controller=AdminDashboard&amp;token=6a9ee1277b9c14c3fc2f5aa274dbaeb5\" class=\"btn btn-primary py-1 mt-3\">
    <i class=\"material-icons\">arrow_back</i>
    Back
  </a>
</div>
  <div class=\"mobile-layer\"></div>

      <div id=\"footer\" class=\"bootstrap\">
    
</div>
  

      <div class=\"bootstrap\">
      <div class=\"modal fade\" id=\"modal_addons_connect\" tabindex=\"-1\">
\t<div class=\"modal-dialog modal-md\">
\t\t<div class=\"modal-content\">
\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
\t\t\t\t<h4 class=\"modal-title\"><i class=\"icon-puzzle-piece\"></i> <a target=\"_blank\" href=\"https://addons.prestashop.com/?utm_source=back-office&utm_medium=modules&utm_campaign=back-office-EN&utm_content=download\">PrestaShop Addons</a></h4>
\t\t\t</div>
\t\t\t
\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t<!--start addons login-->
\t\t\t<form id=\"addons_login_form\" method=\"post\" >
\t\t\t\t<div>
\t\t\t\t\t<a href=\"https://addons.prestashop.com/en/login?email=themes%40magentech.com&amp;firstname=Magen&amp;lastname=Tech&amp;website=http%3A%2F%2Fdev.ytcvn.com%2Fytc_templates%2Fprestashop%2Fsp_topdeals_1770%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-EN&amp;utm_content=download#createnow\"><img class=\"img-responsive center-block\" src=\"/ytc_templates/prestashop/sp_topdeals_1770/sp_admin/themes/default/img/prestashop-addons-logo.png\" alt=\"Logo PrestaShop Addons\"/></a>
\t\t\t\t\t<h3 class=\"text-center\">Connect your shop to PrestaShop's marketplace in order to automatically import all your Addons purchases.</h3>
\t\t\t\t\t<hr />
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Don't have an account?</h4>
\t\t\t\t\t\t<p class='text-justify'>Discover the Power of PrestaShop Addons! Explore the PrestaShop Official Marketplace and find over 3 500 innovative modules and themes that optimize conversion rates, increase traffic, build customer loyalty and maximize your productivity</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Connect to PrestaShop Addons</h4>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"username_addons\" name=\"username_addons\" type=\"text\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-key\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"password_addons\" name=\"password_addons\" type=\"password\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<a class=\"btn btn-link float-right _blank\" href=\"//addons.prestashop.com/en/forgot-your-password\">I forgot my password</a>
\t\t\t\t\t\t\t<br>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"row row-padding-top\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<a class=\"btn btn-default btn-block btn-lg _blank\" href=\"https://addons.prestashop.com/en/login?email=themes%40magentech.com&amp;firstname=Magen&amp;lastname=Tech&amp;website=http%3A%2F%2Fdev.ytcvn.com%2Fytc_templates%2Fprestashop%2Fsp_topdeals_1770%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-EN&amp;utm_content=download#createnow\">
\t\t\t\t\t\t\t\tCreate an Account
\t\t\t\t\t\t\t\t<i class=\"icon-external-link\"></i>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<button id=\"addons_login_button\" class=\"btn btn-primary btn-block btn-lg\" type=\"submit\">
\t\t\t\t\t\t\t\t<i class=\"icon-unlock\"></i> Sign in
\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div id=\"addons_loading\" class=\"help-block\"></div>

\t\t\t</form>
\t\t\t<!--end addons login-->
\t\t\t</div>


\t\t\t\t\t</div>
\t</div>
</div>

    </div>
  
";
        // line 1286
        $this->displayBlock('javascripts', $context, $blocks);
        $this->displayBlock('extra_javascripts', $context, $blocks);
        $this->displayBlock('translate_javascripts', $context, $blocks);
        echo "</body>
</html>";
    }

    // line 82
    public function block_stylesheets($context, array $blocks = [])
    {
    }

    public function block_extra_stylesheets($context, array $blocks = [])
    {
    }

    // line 1175
    public function block_content_header($context, array $blocks = [])
    {
    }

    // line 1176
    public function block_content($context, array $blocks = [])
    {
    }

    // line 1177
    public function block_content_footer($context, array $blocks = [])
    {
    }

    // line 1178
    public function block_sidebar_right($context, array $blocks = [])
    {
    }

    // line 1286
    public function block_javascripts($context, array $blocks = [])
    {
    }

    public function block_extra_javascripts($context, array $blocks = [])
    {
    }

    public function block_translate_javascripts($context, array $blocks = [])
    {
    }

    public function getTemplateName()
    {
        return "__string_template__808be23115de70f4ef16f1c5acbaa5cebd725956c8a7f95623cf8977970107aa";
    }

    public function getDebugInfo()
    {
        return array (  1376 => 1286,  1371 => 1178,  1366 => 1177,  1361 => 1176,  1356 => 1175,  1347 => 82,  1339 => 1286,  1230 => 1179,  1227 => 1178,  1224 => 1177,  1221 => 1176,  1219 => 1175,  122 => 82,  39 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__808be23115de70f4ef16f1c5acbaa5cebd725956c8a7f95623cf8977970107aa", "");
    }
}
