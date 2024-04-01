<? 
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/head.php");

	$Category="product";
	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/header.php");
?>

	<!--Container-->
	<div id="container">
		<?	include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/left_side.php"); ?>

		<!-- Content -->
		<div id="content">
			<!-- 제품 카테고리 대시보드 -->
			<div class="inner dashboard">

				<!-- 제품등록 현황 -->
				<div id="product_count">
					<div class="float-wrap">
						<h2 class="float-l">제품 등록 현황</h2>
						<span class="float-r"><a href="product_list.php" class="button btn-ok">제품목록 바로가기</a></span>
					</div>
					
					<table class="dash-count mt10">
						<colgroup>
							<col style="width:33.33%;"><col><col style="width:33.33%;">
						</colgroup>
						<tbody>
							<tr>
								<td><em class="opensans">156</em>전체 등록 제품</td>
								<td><em class="opensans">145</em>판매중인 제품</td>
								<td><em class="opensans">11</em>판매대기 제품</td>
							</tr>
						</tbody>
					</table>
				</div><!-- END 제품등록 현황 -->

				
				<!-- 제품 판매 현황 -->
				<div id="product_rank" class="mt60">
					<div class="float-wrap">
						<h2 class="float-l">제품 판매 현황</h2>
						<span class="float-r btn-inline"><a href="#" class="button btn-ok">매출통계 바로가기</a></span>
					</div>

					<!-- 제품 누적 판매 순위 -->
					<h3 class="mt30">제품 누적 판매 순위<span class="toggle-btn-sm on"></span></h3>
					<ul class="dash-rank mb50">
						<li>
							<em class="winner">1</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1444380445.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em class="winner">2</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1443865160.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em class="winner">3</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1443863971.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>4</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1444902338.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li class="mr0">
							<em>5</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1448437076.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>6</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1443781335.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>7</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1443864707.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>8</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1443863971.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>9</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1443864707.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li class="mr0">
							<em>10</em>
							<p class="thumb"><img src="http://merphil.co.kr/_ADM/data/goodsImages/GOODS1_1445505201.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
					</ul><!-- END 제품 누적 판매 순위 -->

					<!-- 이번달 판매 순위 -->
					<h3 class="mt20">이번달 판매 순위<span class="toggle-btn-sm on"></span></h3>
					<ul class="dash-rank mb50">
						<li>
							<em>1</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>2</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>3</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>4</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li class="mr0">
							<em>5</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>6</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>7</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>8</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>9</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li class="mr0">
							<em>10</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
					</ul><!-- END 이번달 판매 순위 -->

					<!-- 이번주 판매 순위 -->
					<h3 class="mt20">이번주 판매 순위<span class="toggle-btn-sm on"></span></h3>
					<ul class="dash-rank">
						<li>
							<em>1</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>2</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>3</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>4</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li class="mr0">
							<em>5</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>6</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>7</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>8</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li>
							<em>9</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
						<li class="mr0">
							<em>10</em>
							<p class="thumb"><img src="/_dhadm/image/common/thumb.jpg" alt="@제품명" width="85" height="85"></p>
							<dl class="info">
								<dt>코스모 소파</dt>
								<dd>- 판매 : 250개</dd>
								<dd>- 15,658,000 원</dd>
							</dl>
						</li>
					</ul><!-- END 이번주 판매 순위 -->
				</div><!-- END 제품 판매 현황 -->
			</div><!-- END 제품 카테고리 대시보드 -->

		</div><!-- END Content -->
	</div><!--END Container-->

<? include($_SERVER['DOCUMENT_ROOT']."/_dhadm/include/footer.php"); ?>