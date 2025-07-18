# Buy Stage Plugin for WebEngine CMS

A comprehensive plugin for displaying Mu Online Season 6 character sets with pricing and bonuses. Features admin panel management, customizable stages, and responsive widget positioning.

## Features

- ✅ **Stage Management** - Create and manage multiple purchase stages
- ✅ **Item Management** - Configure items for all Mu Online character classes  
- ✅ **Admin Panel Integration** - Full admin interface for easy management
- ✅ **Responsive Widget** - Positionable on left or right side
- ✅ **Modal Details** - Detailed item view with character breakdowns
- ✅ **Season 6 Support** - Pre-configured for all S6 character classes
- ✅ **Wing Support** - Includes small wings for each stage
- ✅ **Enhancement Display** - Shows +7, +4 Add options and customizable levels
- ✅ **Payment Integration Ready** - Easy integration with payment systems
- ✅ **Mobile Responsive** - Works on all device sizes

## Pre-configured Character Classes

The plugin comes with default setups for all Mu Online Season 6 characters:

### Wizard Line
- Dark Wizard, Soul Master, Grand Master
- **Equipment**: Leather Set + Skull Staff
- **Wings**: Wings of Elf, Wings of Heaven, etc.

### Knight Line  
- Dark Knight, Blade Knight, Blade Master
- **Equipment**: Leather Set + Short Sword
- **Wings**: Various wings per stage

### Elf Line
- Fairy Elf, Muse Elf, High Elf  
- **Equipment**: Leather Set + Short Bow
- **Wings**: Stage-appropriate wings

### Magic Gladiator Line
- Magic Gladiator, Duel Master
- **Equipment**: Leather Set + Lightning Sword
- **Wings**: Enhanced wings per stage

### Dark Lord Line
- Dark Lord, Lord Emperor
- **Equipment**: Scale Set + Crystal Sword
- **Wings**: Premium wings

### Summoner Line
- Summoner, Bloody Summoner, Dimension Master
- **Equipment**: Vine Set + Stick
- **Wings**: Special summoner wings

## Default Stage Configuration

### Stage 1: Beginner Stage ($50.00)
- **Items**: +7 Enhancement, +4 Additional Options
- **Wings**: Small Wings (Wings of Elf)
- **Description**: Perfect starter set for new players

### Stage 2: Intermediate Stage ($100.00)  
- **Items**: +9 Enhancement, +4 Additional Options
- **Wings**: Medium Wings (Wings of Heaven)
- **Description**: Enhanced equipment for advancing players

### Stage 3: Advanced Stage ($200.00)
- **Items**: +11 Enhancement, +4 Additional Options  
- **Wings**: Large Wings (Wings of Satan)
- **Description**: High-level equipment for experienced players

### Stage 4: Expert Stage ($350.00)
- **Items**: +13 Enhancement, +4 Additional Options
- **Wings**: Elite Wings (Wings of Misery)  
- **Description**: Elite equipment for veteran players

### Stage 5: Master Stage ($500.00)
- **Items**: +15 Enhancement, +4 Additional Options
- **Wings**: Master Wings (Wings of Soul)
- **Description**: Ultimate equipment for master players

## Installation Instructions

### Step 1: Upload Plugin Files
1. Create directory: `includes/plugins/buy_stage/`
2. Upload all plugin files to this directory:
   - `loader.php`
   - `admin.php` 
   - `style.css`
   - `script.js`
   - `template_integration.php`

### Step 2: Install via Admin Panel
1. Go to your WebEngine admin panel
2. Navigate to **Plugin Manager** → **Import Plugin**
3. Upload the `buy_stage_plugin.xml` file
4. Click **Install**
5. Enable the plugin

### Step 3: Add Admin Menu (Optional)
Create file: `admincp/modules/buy_stage_admin.php`
```php
<?php include(__PATH_PLUGINS__.'buy_stage/admin.php'); ?>
```

Add to your admin navigation:
```html
<a href="index.php?module=buy_stage_admin">Buy Stage Admin</a>
```

### Step 4: Display Widget in Templates
Add to your template files (e.g., `index.php`):

```php
<!-- Include CSS -->
<link rel="stylesheet" href="includes/plugins/buy_stage/style.css">

<!-- Display widget (right side) -->
<?php if(function_exists('displayBuyStageWidget')): ?>
    <?php echo displayBuyStageWidget('right'); ?>
<?php endif; ?>

<!-- Include JavaScript -->
<script src="includes/plugins/buy_stage/script.js"></script>
```

## Admin Panel Usage

### Managing Stages
1. Go to **Buy Stage Admin** → **Manage Stages**
2. **Add New Stage**: Fill form with stage details
3. **Edit Stage**: Click Edit button on existing stages
4. **Delete Stage**: Click Delete (removes stage and all items)
5. **Enable/Disable**: Toggle stage visibility

### Managing Items
1. Go to **Buy Stage Admin** → **Manage Items**  
2. **Add Items**: Select stage, character class, item details
3. **Configure Enhancement**: Set +level and additional options
4. **Mark Wings**: Enable wing flag for wing items
5. **Delete Items**: Remove individual items

### Plugin Settings
1. Go to **Buy Stage Admin** → **Settings**
2. **Widget Position**: Choose left or right side
3. **Enable/Disable**: Toggle widget visibility
4. **Display Options**: Show/hide prices and bonuses

## Widget Controls

### User Controls
- **Minimize/Maximize**: Click minimize button in header
- **Switch Sides**: Click exchange button to change position
- **View Details**: Click "View Details" for item breakdown
- **Buy Now**: Click to proceed to payment

### Position Memory
The widget remembers user preferences:
- **Position** (left/right)
- **Minimized state**
- **Settings stored** in browser localStorage

## Customization

### Widget Positioning
```php
// Display on left side
echo displayBuyStageWidget('left');

// Display on right side  
echo displayBuyStageWidget('right');
```

### Theme Customization
```css
/* Custom theme */
.buy-stage-widget.custom-theme {
    background: linear-gradient(135deg, #your-color1, #your-color2);
}

/* Dark theme */
.buy-stage-widget.dark-theme {
    background: linear-gradient(135deg, #2c3e50, #34495e);
}
```

### JavaScript Integration
```javascript
// Change theme dynamically
setWidgetTheme('dark-theme');

// Hide widget on mobile
@media (max-width: 480px) {
    .buy-stage-widget.mobile-hidden { display: none; }
}
```

## Payment Integration

The plugin is ready for payment integration. Modify the `buyStage()` function in `script.js`:

### PayPal Integration
```javascript
function buyStage(stageId) {
    window.location.href = 'paypal.php?item=stage_' + stageId;
}
```

### WebEngine Donation System
```javascript
function buyStage(stageId) {
    window.location.href = 'index.php?module=donation&stage=' + stageId;
}
```

### Custom Payment Processor
```javascript
function buyStage(stageId) {
    // Get stage data via AJAX
    $.post('payment.php', {stage_id: stageId}, function(response) {
        // Handle payment
    });
}
```

## Database Structure

### Main Stages Table
```sql
webengine_buy_stage:
- id (Primary Key)
- stage_number (Stage order)
- stage_name (Display name)  
- description (Stage description)
- price (Decimal price)
- bonus_text (Bonus description)
- is_active (Enable/disable)
- created_date (Timestamp)
```

### Items Table
```sql
webengine_buy_stage_items:
- id (Primary Key)
- stage_id (Foreign Key)
- character_class (Character name)
- item_name (Item name)
- item_type (Armor/Weapon/etc)
- enhancement_level (+level)
- additional_options (+add)
- is_wing (Boolean)
- created_date (Timestamp)
```

## Manual Database Management

### Add Custom Stage
```sql
INSERT INTO webengine_buy_stage 
(stage_number, stage_name, description, price, bonus_text) 
VALUES (6, 'God Stage', 'Ultimate divine equipment', 1000.00, '+15 God Items, Divine Wings');
```

### Add Items for Character
```sql
INSERT INTO webengine_buy_stage_items 
(stage_id, character_class, item_name, item_type, enhancement_level, additional_options, is_wing) 
VALUES 
(6, 'Dark Knight', 'Dragon Armor', 'Armor', 15, 4, 0),
(6, 'Dark Knight', 'Dragon Sword', 'Weapon', 15, 4, 0),
(6, 'Dark Knight', 'Wings of Dragon', 'Wings', 0, 4, 1);
```

### View Stage Items
```sql
SELECT s.stage_name, i.character_class, i.item_name, i.enhancement_level 
FROM webengine_buy_stage s 
JOIN webengine_buy_stage_items i ON s.id = i.stage_id 
WHERE s.stage_number = 1;
```

## Troubleshooting

### Widget Not Appearing
1. Check if plugin is enabled in admin panel
2. Verify `displayBuyStageWidget()` function is called
3. Ensure CSS file is loaded
4. Check browser console for JavaScript errors

### Database Errors  
1. Verify database connection in `loader.php`
2. Check if tables were created properly
3. Ensure proper SQL Server permissions
4. Review WebEngine database configuration

### Admin Panel Issues
1. Check file permissions on plugin directory
2. Verify admin access permissions
3. Ensure all plugin files are uploaded
4. Check WebEngine admin panel access

### Modal Not Working
1. Verify jQuery is loaded before plugin script
2. Check for JavaScript conflicts  
3. Ensure FontAwesome is loaded for icons
4. Test AJAX endpoint manually

## Browser Compatibility

- ✅ Chrome 60+
- ✅ Firefox 55+  
- ✅ Safari 12+
- ✅ Edge 79+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Dependencies

- **WebEngine CMS 1.2.6+**
- **jQuery 3.0+**
- **Bootstrap 3.0+ or 4.0+** (for styling)
- **FontAwesome 4.0+** (for icons)
- **SQL Server** (for database)

## Security Features

- ✅ **SQL Injection Protection** - Prepared statements
- ✅ **XSS Prevention** - HTML sanitization
- ✅ **CSRF Protection** - Admin-only access
- ✅ **Input Validation** - Server-side validation
- ✅ **File Security** - WebEngine constant checks

## Performance Considerations

- **Caching**: Plugin uses minimal database queries
- **Lazy Loading**: AJAX loading for stage details
- **Optimized CSS**: Efficient selectors and animations
- **Memory Usage**: Lightweight JavaScript footprint
- **Mobile Optimized**: Responsive design patterns

## Support & Updates

- **Version**: 1.0.0
- **Compatibility**: WebEngine CMS 1.2.6
- **Updates**: Check WebEngine plugin repository
- **Support**: WebEngine CMS community forums

## License

This plugin is released under the same license as WebEngine CMS (MIT License).

---

**Created for WebEngine CMS** - A comprehensive solution for Mu Online server websites.