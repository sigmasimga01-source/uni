<div class="order-stats">
  <div class="stat-card stat-pending">
    <div class="stat-number"><?= $pendingCount ?></div>
    <div class="stat-label">Pending</div>
  </div>
  <div class="stat-card stat-completed">
    <div class="stat-number"><?= $completedCount ?></div>
    <div class="stat-label">Completed</div>
  </div>
  <div class="stat-card stat-cancelled">
    <div class="stat-number"><?= $cancelledCount ?></div>
    <div class="stat-label">Cancelled</div>
  </div>
  <div class="stat-card stat-total">
    <div class="stat-number"><?= count($allOrders) ?></div>
    <div class="stat-label">Total Orders</div>
  </div>
</div>