<form method="POST" class="admin-form">
  <?php if ($editingItem): ?>
    <input type="hidden" name="item_id" value="<?= $editingItem['item_id'] ?>">
  <?php endif; ?>

  <div class="form-group">
    <label for="name">Product Name</label>
    <input type="text" id="name" name="name" required placeholder="Enter product name"
      value="<?= $editingItem ? $editingItem['name'] : '' ?>">
  </div>

  <div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="3" placeholder="Enter product description"><?= $editingItem ? $editingItem['description'] : '' ?></textarea>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="price">Price ($)</label>
      <input type="number" id="price" name="price" step="0.01" min="0.01" required placeholder="0.00"
        value="<?= $editingItem ? $editingItem['price'] : '' ?>">
    </div>

    <div class="form-group">
      <label for="stock">Stock Quantity</label>
      <input type="number" id="stock" name="stock" min="0" required placeholder="0"
        value="<?= $editingItem ? $editingItem['stock'] : '' ?>">
    </div>
  </div>

  <div class="form-group">
    <label for="image">Image URL</label>
    <input type="url" id="image" name="image" placeholder="https://example.com/image.png"
      value="<?= $editingItem ? $editingItem['image'] ?? '' : '' ?>">
  </div>

  <?php if ($editingItem): ?>
    <button type="submit" name="update_item" class="btn btn-primary" style="margin-bottom: 0.5rem; padding:1rem;">Update Item</button>
    <a href="products.php" class="btn btn-secondary">Cancel</a>
  <?php else: ?>
    <button type="submit" name="add_item" class="btn btn-success">Add Item</button>
  <?php endif; ?>
</form>