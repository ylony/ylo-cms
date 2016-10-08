<?php
class paypal{
	function write_item_data($price){
		global $security, $account;
			/* Protection */
			$price = $security->protect_int($price);
			$transaction_id = $account->generate_key();
			?>
		<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
		<!-- Indication du montant HT du panier ou TTC si la TVA n'est pas détaillée */-->
		<input name="amount" type="hidden" value="<?php echo $price; ?>" />
		<!--/* Indication de la devise */-->
		<input name="currency_code" type="hidden" value="EUR" />
		<!--/* Indication du montant des frais de port */-->
		<input name="shipping" type="hidden" value="0" />-->
		<!--/* Indication du montant de la TVA (ou 0.00) */-->
		<input name="tax" type="hidden" value="0" />
		<!--/* Indication de l'URL de retour automatique */-->
		<input name="return" type="hidden" value="http://127.0.0.1/elo/store/?return_paypal=true&process=auto_return" />
		<!--/* Indication de l'URL de retour si annulation du paiement */-->
		<input name="cancel_return" type="hidden" value="http://127.0.0.1/elo/store/?return_paypal=true&process=cancel" />
		<!--/* Indication de l'URL de retour pour contrôler le paiement */-->
		<input name="notify_url" type="hidden" value="http://127.0.0.1/elo/store/?return_paypal=true&process=ipn" />
		<!--/* Indication du type d'action */-->
		<input name="cmd" type="hidden" value="_xclick" />-->
		<!--/* Indication de l'adresse e-mail test du vendeur (a remplacer par l'e-mail de votre compte Paypal en production) */-->
		<input name="business" type="hidden" value="hylow423-facilitator@gmail.com" />
		<!--/* Indication du libellé de la commande qui apparaitra sur Paypal */-->
		<input name="item_name" type="hidden" value="Division boosting B5 -> D1" />
		<!--/* Indication permettant à l'acheteur de laisser un message lors du paiement */-->
		<input name="no_note" type="hidden" value="1" />
		<!--/* Indication de la langue */-->
		<input name="lc" type="hidden" value="EN" />
		<!--/* Indication du type de paiement */-->
		<input name="bn" type="hidden" value="PP-BuyNowBF" />
		<!--/* Indication du numéro de la commande (très important) */-->
		<input name="custom" type="hidden" value="<?php echo $transaction_id ?>" /><?php
	}
}
$paypal = new paypal;