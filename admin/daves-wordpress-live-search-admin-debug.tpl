<?php include dirname(__FILE__)."/admin_header.tpl"; ?>
<h2>
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=settings"; ?>" class="nav-tab"><?php _e("Settings", 'dwls'); ?></a>
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=design"; ?>" class="nav-tab"><?php _e("Design", 'dwls'); ?></a>
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=advanced"; ?>" class="nav-tab"><?php _e("Advanced", 'dwls'); ?></a>
<?php if($enableDebugger) : ?><a href="<?php echo $_SERVER['REQUEST_URI']."&tab=debug"; ?>" class="nav-tab nav-tab-active"><?php _e("Debug", 'dwls'); ?></a><?php endif; ?>
</h2>

<!-- Debugger Body -->
<div style="width: 500px; height: 800px;overflow-y:auto;border: 1px dotted #aaa;margin: 10px 0;padding: 1em;"><?php echo $debug_output; ?></div>

<?php include dirname(__FILE__)."/admin_footer.tpl"; ?>
</div>