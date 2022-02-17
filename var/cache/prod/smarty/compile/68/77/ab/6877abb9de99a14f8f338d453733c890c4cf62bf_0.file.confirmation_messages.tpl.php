<?php
/* Smarty version 3.1.34-dev-7, created on 2020-12-10 03:00:15
  from 'E:\xampp\htdocs\ytc_templates\prestashop\sp_topdeals_1770\sp_admin\themes\new-theme\template\components\layout\confirmation_messages.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5fd1d58f938741_08967432',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6877abb9de99a14f8f338d453733c890c4cf62bf' => 
    array (
      0 => 'E:\\xampp\\htdocs\\ytc_templates\\prestashop\\sp_topdeals_1770\\sp_admin\\themes\\new-theme\\template\\components\\layout\\confirmation_messages.tpl',
      1 => 1607572732,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5fd1d58f938741_08967432 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['confirmations']->value) && count($_smarty_tpl->tpl_vars['confirmations']->value) && $_smarty_tpl->tpl_vars['confirmations']->value) {?>
  <div class="bootstrap">
    <div class="alert alert-success" style="display:block;">
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['confirmations']->value, 'conf');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['conf']->value) {
?>
        <?php echo $_smarty_tpl->tpl_vars['conf']->value;?>

      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>
  </div>
<?php }
}
}
