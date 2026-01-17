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
        <td>#<?= $item['item_id'] ?></td>
        <td><?= $item['name'] ?></td>
        <td><?= $item['description'] ?? '-' ?></td>
        <td style="color: green; font-weight: bold;">$<?= $item['price'] ?></td>
        <td>
          <span class="<?= $item['stock'] > 0 ? 'stock-ok' : 'stock-out' ?>">
            <?= $item['stock'] ?>
          </span>
        </td>
        <td style="display: flex; gap: 10px;">
          <button onclick="window.location.href='?edit_item=<?= $item['item_id'] ?>'" class="btn btn-primary ">Edit</button>
          <form method="POST" style="display: inline; padding: 0; margin: 0; box-shadow: none; background: transparent;">
            <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
            <button type="submit" name="delete_item" class="btn btn-danger "
              onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>