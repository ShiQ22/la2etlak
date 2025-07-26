# PROJECT_LOG.md – la2etlak Lost & Found Customization
## Branch: feature/lost-found
## Template: LaraClassifier Base

---

### ✅ Completed Work (Before This Session)

#### [0.1] Lost/Found Post Type – Frontend UI
- Added `type` ENUM field to `posts` table (values: 'lost', 'found')
- Created modal to select Lost or Found before creating a listing
- Persisted `type` on post creation and DB
- Displayed red/green badge on posts in:
  - Grid listings
  - Similar listings
  - User dashboard (frontend)

#### [1.0] Admin Panel Integration of Lost/Found – COMPLETED
- Added `lost_or_found` text column in admin list view.
- Registered Lost/Found dropdown filter.
- Added `lost_or_found` select field on the edit form (select2_from_array).

#### [2.0] Search Enhancements (Global)
- [x] Add “Lost / Found / All” dropdown to main search bar  
- [x] Add “Lost / Found / All” dropdown to sidebar  
- [x] Remove price-based sort options  
- [x] Add “Lost first” & “Found first” sort controls  
- [x] Preserve “Distance” & “Date” sorts  
- [x] Wire up back-end ORDER BY logic for lost/found via boolean expressions  
- [x] Translation keys for `Lost first` & `Found first` in `en` and `ar`  
- [ ] Integrate into:
  - [ ] SearchController  
  - [ ] search traits/helpers (confirm actual files used)  
  - [ ] query builder  
  - [ ] search result templates  

---

### 🔄 Current Work & Roadmap (Pending)

#### [3.0] Report Form Cleanup & Multi-Category

##### [3.0.1] Price & Negotiable Cleanup – **COMPLETED**
- Commented out **price** & **negotiable** fields (create/edit forms) in:
  - Front: multi-step & single-step Blade templates  
  - Search result templates (grid, list, compact)  
  - Account dashboard (`front/account/posts.blade.php`)  
  - Post detail & similar listings  
  - Sidebar filters  
- Disabled backend price filtering:
  - Removed `applyPriceFilter()` call in `Filters.php`  
  - Kept default search logic intact  
- Removed admin Price & Negotiable fields from:
  - Backpack PostController’s `addField()` calls  

##### [3.0.2] Multi-Category Linking – **IN PROGRESS**  
- **Option A (Recommended)**: Add many-to-many pivot (`post_category`)  
  - **DB**: Create migration for `post_category(post_id, category_id)`  
  - **Model**: `Post` ↔️ `categories()` relation; remove single `category_id` foreign key usage  
  - **Forms**:  
    - Front-end: use Select2 multiple or checkboxes to choose several categories  
    - Admin: update Backpack fields to use `select2_from_array` with multiple  
  - **Custom Fields**: loop through each chosen category to display its fields  
  - **Search**: join `post_category` in filters so any matching category returns the post  
  - **Admin List**: show categories as comma-separated labels  
- **Next**: Draft migration and update Eloquent relations (step-by-step)

#### [4.0] Claimed Status
- [ ] Add ENUM `claimed` to `posts.status`
- [ ] Add Claim button to post page
- [ ] Mark post as archived + claimed
- [ ] Show “Claimed” in:
  - [ ] User dashboard
  - [ ] Admin dashboard

#### [5.0] User Verification
- [ ] Add `is_verified` boolean to users table
- [ ] Show verification checkmark in:
  - [ ] Post author section
  - [ ] User dashboard
  - [ ] Admin users list
- [ ] Add toggle button in Admin User controller

---

### 💾 Recent Commits on `feature/lost-found-search`

#### [2.0.1] (2025-07-24)
- Removed `priceAsc`/`priceDesc` entries from sort options  
- Re-added `distance` sort as first option  
- Added `lostFirst` & `foundFirst` keys in:
  - `OrderBy.php` (SQL ordering via boolean comparisons)  
  - `SidebarTrait.php` (menu entries)  
- Kept `date` sort intact  
- Added translation strings in `resources/lang/en/global.php` and `ar/global.php`  
- Cleared view/cache to reflect changes  

---
