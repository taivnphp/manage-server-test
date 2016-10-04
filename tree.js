/**
			Node Expand click
			*/
			function nodeAutoClick($node){				
				if($node.length && $node.hasClass('expandable')){					
					$node.find('.hitarea:first').trigger('click');
				}				
			}
			/**
			Check Node Auto Expand
			**/
			function nodeAutoExpand(){

				var $partSelected = $('#tree-selector').val();
				
				$('#navigation-tree a.nav-item').each(function(){
					var $thisItem = $(this),			
						$thisHref = $.trim($thisItem.attr('href'));

					if($thisHref === $partSelected){
						//check node level 1
						if($thisItem.hasClass('nav-tm')){
							var $thisItemParent = $thisItem.parent();
							nodeAutoClick($thisItemParent);
							return;	
						}

						//check node level 3
						if($thisItem.hasClass('nav-park')){
							var $thisItemLi = $thisItem.parent();
							var $ulItems    = $thisItem.closest('ul');
							var $liItemsLv2 = $ulItems.parent();
							var $liItemsLv1 = $liItemsLv2.parent().parent();

							nodeAutoClick($liItemsLv1);
							nodeAutoClick($liItemsLv2);
							nodeAutoClick($thisItemLi);
							return;
						}

						//check node level 3
						if($thisItem.hasClass('nav-leaf')){
							var $thisItemLi = $thisItem.parent();
							var $ulItems    = $thisItem.closest('ul');
							var $liItemsLv3 = $ulItems.parent();
							var $liItemsLv2 = $liItemsLv3.parent().parent();
							var $liItemsLv1 = $liItemsLv2.parent().parent();
												
							nodeAutoClick($liItemsLv1);
							nodeAutoClick($liItemsLv2);
							nodeAutoClick($liItemsLv3);					
							return;
						}
					}	
				});				
			}
