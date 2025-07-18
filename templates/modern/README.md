# WebEngine CMS - Modern Template

A beautiful, responsive, and feature-rich dark theme template for WebEngine CMS 1.2.6.

## Features

### 🎨 **Modern Design**
- Dark theme with beautiful gradient accents
- Clean, minimalist interface
- Gaming-focused color scheme
- Smooth animations and transitions

### 📱 **Fully Responsive**
- Mobile-first design approach
- Optimized for all screen sizes
- Touch-friendly navigation
- Responsive tables and components

### ⚡ **Performance Optimized**
- Lightweight and fast loading
- Optimized CSS and JavaScript
- Efficient background effects
- Smooth 60fps animations

### 🎯 **User Experience**
- Intuitive navigation
- Interactive elements
- Real-time server status updates
- Advanced notification system

### 🔧 **Developer Friendly**
- Well-organized code structure
- CSS custom properties for easy theming
- Modular JavaScript architecture
- Comprehensive documentation

## Installation

1. Copy the `modern` folder to your `templates/` directory
2. Update your WebEngine configuration to use the modern template:
   ```json
   {
     "website_template": "modern"
   }
   ```
3. Clear any cache if applicable

## File Structure

```
templates/modern/
├── css/
│   ├── style.css          # Main stylesheet
│   ├── components.css     # Component-specific styles
│   ├── animations.css     # Animation definitions
│   └── responsive.css     # Responsive design rules
├── js/
│   ├── main.js           # Core functionality
│   ├── events.js         # WebEngine-specific events
│   └── particles.min.js  # Background particle effects
├── img/
│   ├── logo.png          # Site logo
│   └── flags/            # Language flag icons
├── inc/
│   ├── template.functions.php  # Template helper functions
│   └── modules/
│       ├── sidebar.php   # Sidebar component
│       └── footer.php    # Footer component
├── index.php             # Main template file
└── favicon.ico           # Site favicon
```

## Customization

### Colors

The template uses CSS custom properties for easy color customization. Edit the `:root` selector in `css/style.css`:

```css
:root {
    --primary-color: #6366f1;      /* Primary accent color */
    --secondary-color: #ec4899;    /* Secondary accent color */
    --bg-primary: #0f172a;         /* Main background */
    --bg-secondary: #1e293b;       /* Secondary background */
    --text-primary: #f8fafc;       /* Primary text color */
    --text-secondary: #cbd5e1;     /* Secondary text color */
}
```

### Fonts

The template uses two font families:
- **Inter** - For body text and UI elements
- **Orbitron** - For gaming-style headings and branding

To change fonts, update the CSS variables:

```css
:root {
    --font-primary: 'Your Font', sans-serif;
    --font-gaming: 'Your Gaming Font', sans-serif;
}
```

### Logo

Replace `img/logo.png` with your own logo. Recommended dimensions: 200x60 pixels.

### Background Effects

The template includes animated particle effects. To disable:

```javascript
// In main.js, comment out this line:
// initializeParticles();
```

Or customize the particle configuration in the `initializeParticles()` function.

## Components

### Navigation
- Responsive navbar with mobile menu
- Active page highlighting
- User dropdown with profile options
- Language selector integration

### Server Status Bar
- Real-time online player count
- Server status indicator
- Progress bar for server capacity
- Server time display

### Sidebar Widgets
- Server information display
- Social media links
- Latest news preview
- Top players ranking
- Quick statistics

### Footer
- Comprehensive site information
- Social media integration
- Server details
- Copyright and credits

## JavaScript Features

### Core Functionality (`main.js`)
- Preloader with smooth transitions
- Scroll-to-top button
- Time updates and synchronization
- Form enhancements
- Animation triggers

### WebEngine Integration (`events.js`)
- AJAX form handling
- Real-time server status updates
- Character and guild profile modals
- Dynamic content loading
- Notification system

## Browser Support

- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+

## Performance Tips

1. **Optimize Images**: Compress logo and background images
2. **CDN Usage**: The template uses CDNs for Bootstrap and Font Awesome
3. **Caching**: Enable browser caching for static assets
4. **Minification**: Consider minifying CSS and JavaScript for production

## Accessibility

The template includes:
- Semantic HTML structure
- ARIA labels and roles
- Keyboard navigation support
- Screen reader compatibility
- High contrast ratios
- Reduced motion support

## Troubleshooting

### Common Issues

**Template not loading:**
- Check file permissions
- Verify template name in configuration
- Clear cache

**JavaScript errors:**
- Ensure all JS files are properly loaded
- Check browser console for specific errors
- Verify CDN resources are accessible

**Styling issues:**
- Check CSS file paths
- Verify Bootstrap CSS is loading
- Clear browser cache

## Contributing

To contribute to the modern template:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This template is licensed under the MIT License, same as WebEngine CMS.

## Credits

- **Design**: Modern gaming-inspired interface
- **Icons**: Font Awesome 6
- **Framework**: Bootstrap 5
- **Fonts**: Google Fonts (Inter, Orbitron)
- **Effects**: Particles.js

## Support

For support with this template:
- Check the WebEngine CMS documentation
- Visit the official WebEngine Discord
- Report issues on GitHub

---

**Made with ❤️ for the WebEngine CMS community**