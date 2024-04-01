			<h1 class="<?=$Category?>">
				<?if($Category=="product"){?>제품관리<?}?>
				<?if($Category=="setting"){?>환경설정<?}?>
			</h1>
			
			<!-- SNB -->
			<ul id="snb">
			<?if($Category=="product"){?>
				<li <?if($PageName=="product_list"){?>class="on"<?}?>><a href="/html/dhadm/product_list.php?d=1">제품목록</a></li>
				<li <?if($PageName=="product_add"){?>class="on"<?}?>><a href="/html/dhadm/product_add.php?d=1">제품등록</a></li>
				<li <?if($PageName=="product_align"){?>class="on"<?}?>><a href="/html/dhadm/product_align.php?d=1">제품진열순서변경</a></li>
				<li <?if($PageName=="product_option"){?>class="on"<?}?>><a href="/html/dhadm/product_option.php?d=1">옵션관리</a></li>
				<li <?if($PageName=="product_stock"){?>class="on"<?}?>><a href="/html/dhadm/product_stock.php?d=1">재고관리</a></li>
				<li <?if($PageName=="product_exhibition"){?>class="on"<?}?>><a href="/html/dhadm/product_exhibition.php?d=1">브랜드/기획전</a></li>
				<li <?if($PageName=="product_category"){?>class="on"<?}?>><a href="/html/dhadm/product_cate.php?d=1">카테고리 관리</a></li>
			<?}?>

			<?if($Category=="setting"){?>
				<li <?if($PageName=="setting_global"){?>class="on"<?}?>><a href="/html/dhadm/setting_global.php?d=1">기본설정</a></li>
				<li <?if($PageName=="setting_policy"){?>class="on"<?}?>><a href="/html/dhadm/setting_policy.php?d=1">약관/정책 설정</a></li>
				<li <?if($PageName=="setting_spam"){?>class="on"<?}?>><a href="/html/dhadm/setting_spam.php?d=1">스팸관리</a></li>
			<?}?>
			</ul><!-- END SNB -->