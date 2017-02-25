<div id="menu">
  <{foreach from=$menu item=module}>
  <h6 id="h-menu-<{$module.slug}>" class="selected"><a href="<{$module.link}>"><span><{$module.name}></span></a></h6>
  <ul id="menu-<{$module.slug}>" class="opened">
    <{foreach from=$module.items item=right}>
      <li<{if $right@last}> class="last"<{/if}>>
      <{if 'logout' == $right.slug}>
      <a href="<{$right.link}>" style='display:none'>
      <{elseif 'change-password' == $right.slug}>
      <a href="<{$right.link}>" style='display:none'>
      <{elseif 'distributor-list' == $right.slug}>
      <a href="#<{$right.link}>" onclick="openMenuTab('<{$right.link}>','<{$right.name}>','tab-<{$right.slug}>');return false;">
      <{else}>
      <a href="#<{$right.link}>" onclick="openMenuTab('<{$right.link}>','<{$right.name}>','<{$right.slug}>');return false;">
      <{/if}>
      <{$right.name}></a></li>
    <{/foreach}>
  </ul>
  <{/foreach}>
</div>