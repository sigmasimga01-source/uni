<table class="cart-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Description</th>
      <th>Price</th>
      <th>Stock</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($allItems as $item): ?>
      <tr>
        <td>#<?= $item->getItemId() ?></td>
        <td><?= $item->getName() ?></td>
        <td><?= $item->getDescription() ?? '-' ?></td>
        <td style="color: green; font-weight: bold;">$<?= $item->getPrice() ?></td>
        <td>
          <span class="<?= $item->getStock() > 0 ? 'stock-ok' : 'stock-out' ?>">
            <?= $item->getStock() ?>
          </span>
        </td>
        <td style="display: flex; gap: 10px;">
          <button onclick="window.location.href='?edit_item=<?= $item->getItemId() ?>'" class="btn btn-primary ">Edit</button>
          <form method="POST" style="display: inline; padding: 0; margin: 0; box-shadow: none; background: transparent;">
            <input type="hidden" name="item_id" value="<?= $item->getItemId() ?>">
            <button type="submit" name="delete_item" class="btn btn-danger "
              onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>