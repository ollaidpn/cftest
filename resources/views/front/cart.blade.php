@extends('layouts.front')

@section('content')
	<!-- Inner Page Breadcrumb -->
	<section class="inner_page_breadcrumb">
		<div class="container">
			<div class="row">
				<div class="col-xl-6 offset-xl-3 text-center">
					<div class="breadcrumb_content">
						<h4 class="breadcrumb_title">Panier</h4>
						<ol class="breadcrumb">
						    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
						    <li class="breadcrumb-item active" aria-current="page">Panier</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Shop Checkouts Content -->
	<section class="shop-checkouts">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-8 col-xl-8">
					<div class="cart_page_form">
						<form action="#">
							<table class="table table-responsive">
							  	<thead>
								    <tr class="carttable_row">
								    	<th class="cartm_title">Nom de la formations</th>
								    	<th class="cartm_title">Prix</th>
								    	<th class="cartm_title">Réduction</th>
								    	<th class="cartm_title">Total</th>
								    </tr>
							  	</thead>
							  	<tbody class="table_body">
								    <tr>
								    	<th scope="row">
								    		<ul class="cart_list">
								    			<li class="list-inline-item pr15"><a href="#"><img src="images/shop/close.png" alt="close.png"></a></li>
								    			<li class="list-inline-item pr20"><a href="#"><img src="images/shop/cart1.png" alt="cart1.png"></a></li>
								    			<li class="list-inline-item"><a class="cart_title" href="#">Introduction Web Design <br> with HTML</a></li>
								    		</ul>
								    	</th>
										<td>16.000 Fcfa</td>
										<td>0 Fcfa</td>
								    	<td class="cart_total">16.000 Fcfa</td>
								    </tr>


							  	</tbody>
							</table>
						</form>
					</div>
					<div class="checkout_form">
						<div class="checkout_coupon ui_kit_button">
							<form class="form-inline">
						    	<input class="form-control" type="search" placeholder="Code de reduction" aria-label="Search">
						    	<button type="button" class="btn btn2" style="background-color: #6c2b69;">Appliquer le code</button>
						    	<button type="button" class="btn btn3" style="border-color: #6c2b69; color: #6c2b69;">Mettre à jour</button>
						    </form>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-xl-4">
					<div class="order_sidebar_widget mb30">
						<h4 class="title">Panier</h4>
						<ul>
							<li class="subtitle"><p>Total <span class="float-right totals color-orose" style="font-size: 2em; color: #6c2b69;">40.900 Fcfa</span></p></li>
						</ul>
					</div>
					<div class="ui_kit_button payment_widget_btn">
						<button type="button" class="btn dbxshad btn-lg btn-thm3 circle btn-block" style="background-color: #6c2b69; border-color: #6c2b69;">Payer</button>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
