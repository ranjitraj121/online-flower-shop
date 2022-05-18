<div class="quick-transaction-info-w">
  <div class="quick-transaction-head">
    <div class="quick-transaction-amount"><?php echo OsMoneyHelper::format_price($transaction->amount); ?></div>
    <div class="lp-processor-logo lp-processor-logo-<?php echo $transaction->processor; ?>"><?php echo $transaction->processor; ?></div>
    <?php OsPaymentsHelper::display_transaction_payment_method_info($transaction->payment_method); ?>
    <div class="lp-transaction-status lp-transaction-status-<?php echo $transaction->status; ?>"><?php echo $transaction->status; ?></div>
  </div>
  <div class="quick-transaction-sub">
    <div><?php echo $transaction->formatted_created_date(OsSettingsHelper::get_date_format()); ?></div>
    <div><?php echo $transaction->token; ?></div>
  </div>
</div>