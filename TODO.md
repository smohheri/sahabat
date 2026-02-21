# TODO: Implement Dynamic Landing Page Images

## Completed Tasks
- [x] Create database migration file (alter_table_add_landing_images.sql)
- [x] Add upload methods in Admin controller (upload_hero_image, upload_about_image)
- [x] Add "Landing Page" menu in admin sidebar
- [x] Create admin view for managing landing images (application/views/admin/landing.php)
- [x] Update landing page to use uploaded images instead of Unsplash

## Pending Tasks
- [ ] Run database migration: Execute the SQL in alter_table_add_landing_images.sql
- [ ] Test the upload functionality
- [ ] Verify images display correctly on landing page

## Database Migration
Run this SQL in your MySQL database:
```sql
ALTER TABLE pengaturan
ADD COLUMN hero_image VARCHAR(255) DEFAULT NULL,
ADD COLUMN about_image VARCHAR(255) DEFAULT NULL AFTER hero_image;
```

## Testing Steps
1. Login to admin panel
2. Go to Pengaturan > Landing Page
3. Upload hero image and about image
4. Check landing page to see if images are displayed
5. If no images uploaded, should fallback to Unsplash images

## Notes
- Images are stored in assets/uploads/landing/
- Supported formats: JPG, PNG (max 2MB)
- Images are automatically replaced when new ones are uploaded
