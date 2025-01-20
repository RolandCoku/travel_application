<?php
$title = 'Edit Travel Package';
$cssFiles = [
  'admin/adminDashboard.css',
  'admin/travel-agency/travel-package/edit.css',
  'boxicons-2.1.4/css/boxicons.min.css'
];

// $package = [
//     'id' => 1,
//     'name' => 'Paris',
//     'description' => 'The city of love',
//     'start_date' => '2022-06-01',
//     'end_date' => '2022-06-10',
//     'price' => 2000,
//     'main_image' => 'paris.jpg',
//     'secondary_images' => ['paris1.jpg', 'paris2.jpg', 'paris3.jpg']
// ];
$package = $data;
require_once app_path('includes/layout-header.php'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />

<div class="container">
  <!-- Sidebar -->
  <?php require_once app_path('includes/travel-agency-admin-sidebar.php'); ?>

  <!-- Main Content -->
  <main>
    <div class="header">
      <h1>Edit Travel Package</h1>
    </div>

    <!-- Edit Travel Package Form -->
    <div class="form-container">
      <form id="edit-travel-package-form" action="/travel-agency/admin/travel-packages/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $package['id'] ?>" />

        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" class="form-control" value="<?= $package['name'] ?>" required />
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="4" class="form-control" required><?= $package['description'] ?></textarea>
        </div>

        <div class="form-group">
          <label for="location">Location</label>
          <input type="text" id="location" name="location" rows="4" class="form-control" value="<?= $package['location'] ?>" required></input>
        </div>
        <div class="form-group">
          <label for="seats">Seat Number</label>
          <input type="text" id="seats" name="seats" rows="4" class="form-control" value="<?= $package['seats'] ?>" required></input>
        </div>

        <div class="form-group row">
          <div class="col">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="<?= $package['start_date'] ?>" required />
          </div>
          <div class="col">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="<?= $package['end_date'] ?>" required />
          </div>
        </div>

        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" id="price" name="price" class="form-control" value="<?= $package['price'] ?>" required />
        </div>

        <div class="form-group">
          <label for="image">Main Image</label>
          <div class="current-image">
            <?php if (!empty($package['main_image'])): ?>
              <img src="/uploads/<?= $package['main_image'] ?>" alt="Main Image" class="preview-image" />
            <?php else: ?>
              <p>No primary images available.</p>
            <?php endif; ?>
          </div>
          <input type="file" id="image" name="image" class="form-control" />
          <small class="text-muted">Leave empty to keep the current image.</small>
        </div>

        <div class="form-group">
          <label for="secondary_images">Secondary Images</label>
          <div class="current-images">
            <?php if (!empty($package['secondary_images'])): ?>
              <?php foreach ($package['secondary_images'] as $image): ?>
                <img src="/uploads/<?= $image ?>" alt="Secondary Image" class="preview-image" />
              <?php endforeach; ?>
            <?php else: ?>
              <p>No secondary images available.</p>
            <?php endif; ?>
          </div>
          <input type="file" id="secondary_images" name="secondary_images[]" class="form-control" multiple />
          <small class="text-muted">Leave empty to keep the current images.</small>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn primary">Update Package</button>
          <a href="/travel-agency/admin/travel-packages" class="btn secondary">Cancel</a>
        </div>
      </form>
    </div>
  </main>

  <!-- Right Sidebar -->
  <div class="right">
    <div class="top">
      <button id="menu-btn">
        <span class="material-icons-sharp"> menu </span>
      </button>
      <div class="profile">
        <div class="info">
          <p>Hello, <b>Admin</b></p>
          <small class="text-muted">Travel Manager</small>
        </div>
        <div class="profile-photo">
          <img src="person2.png" alt="Profile Picture" />
        </div>
      </div>
    </div>
    <div class="sales-analytics">
      <div class="info item">
        <i class='bx bx-edit' style="font-size: 50px; color: #7380ec"></i>
        <h2>Update the fields to edit the travel package details</h2>
      </div>
    </div>

  </div>
</div>

<?php
$jsFile = '/admin/adminDashboard.js';
require_once app_path('includes/layout-footer.php'); ?>

<style>
  .form-container {
    background: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    box-shadow: var(--box-shadow);
    width: 100%;
    margin: 2rem auto;
  }

  .form-group {
    margin-bottom: 1.2rem;
  }

  .form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--color-dark);
  }

  .form-group input,
  .form-group textarea,
  .form-group select {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid var(--color-light);
    border-radius: var(--border-radius-1);
    background: var(--color-info-light);
    color: var(--color-dark);
    font-size: 0.9rem;
    outline: none;
    transition: all 300ms ease;
  }

  .form-group input:focus,
  .form-group textarea:focus,
  .form-group select:focus {
    border-color: var(--color-primary);
  }

  .form-group .current-image,
  .form-group .current-images {
    margin: 1rem 0;
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .preview-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: var(--border-radius-1);
    box-shadow: var(--box-shadow);
  }

  .form-actions {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
  }

  .form-actions .btn {
    padding: 0.8rem 1.6rem;
    border: none;
    border-radius: var(--border-radius-1);
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 300ms ease;
  }

  .form-actions .btn.primary {
    background: var(--color-primary);
    color: var(--color-white);
  }

  .form-actions .btn.primary:hover {
    background: var(--color-primary-variant);
  }

  .form-actions .btn.secondary {
    background: var(--color-light);
    color: var(--color-dark);
  }

  .form-actions .btn.secondary:hover {
    background: var(--color-info-light);
  }
</style>