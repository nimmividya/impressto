var TubePressDomPlayer=(function(){var e=TubePressEvents,d="detached",g=jQuery(document),b=jQuery,a=TubePressAjax,c=function(m,l,k,j,i){var h="#tubepress_detached_player_"+k;a.applyLoadingStyle(h);b(h)[0].scrollIntoView(true)},f=function(n,o,j,i,k,m,l){var h="#tubepress_detached_player_"+l;jQuery(h).html(j);a.removeLoadingStyle(h)};g.bind(e.PLAYER_INVOKE+d,c);g.bind(e.PLAYER_POPULATE+d,f)}());