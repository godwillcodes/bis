# BIS WordPress Theme

A modern, accessible WordPress theme designed for Birnbaum Interpreting Services (BIS), featuring a clean, minimalist design with a focus on user experience and accessibility.

## Overview

The BIS theme is a custom WordPress theme built with Tailwind CSS, Alpine.js, and modern web standards. It provides a professional, award-winning design that emphasizes clarity, accessibility, and performance.

## Features

### Design & User Experience
- **Minimalist Design**: Clean, award-winning aesthetic with focus on content
- **Responsive Layout**: Fully responsive design that works seamlessly across all devices
- **Accessibility First**: Built with WCAG guidelines in mind for inclusive access
- **Modern Typography**: Carefully selected font pairings for optimal readability
- **Smooth Animations**: Subtle, purposeful animations that enhance user experience

### Technical Features
- **Tailwind CSS**: Utility-first CSS framework for rapid, consistent styling
- **Alpine.js**: Lightweight JavaScript framework for interactive components
- **Owl Carousel**: Integrated carousel functionality for dynamic content display
- **ACF Integration**: Full support for Advanced Custom Fields (ACF) repeater fields
- **Custom Post Types**: Support for Services, Industries, and Resources
- **SVG Support**: Full SVG upload and display capabilities
- **Performance Optimized**: Optimized for speed and performance

### Components
- **Banner Component**: Hero sections with customizable backgrounds and CTAs
- **Breadcrumb Navigation**: Minimal, artsy breadcrumb implementation
- **Card Components**: Award-winning card designs for services, industries, and resources
- **Accordion Component**: Interactive FAQ and content accordions
- **Testimonials**: Elegant testimonial displays
- **Logo Carousel**: Dynamic logo carousel for partners and clients

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Advanced Custom Fields (ACF) plugin
- Node.js 14+ (for development)
- Composer (for development)

## Installation

### Standard Installation

1. Upload the theme folder to `/wp-content/themes/`
2. Activate the theme through the WordPress admin panel
3. Configure ACF fields as needed
4. Set up custom menus in Appearance > Menus

### Development Setup

1. Clone the repository:
   ```bash
   git clone [repository-url]
   cd bis
   ```

2. Install dependencies:
   ```bash
   npm install
   composer install
   ```

3. Build assets:
   ```bash
   npm run build
   ```

## Theme Structure

```
bis/
├── components/          # Reusable component templates
│   ├── cards/          # Card components (service, industry, resource)
│   ├── content/        # Content components (accordion, etc.)
│   ├── layout/         # Layout components (banner, breadcrumb)
│   └── sections/       # Section components (CTA, logo carousel)
├── css/                # Compiled CSS files
├── js/                 # JavaScript files
│   ├── accordion.js    # Accordion functionality
│   ├── navigation.js   # Navigation menu handling
│   ├── owl-loader.js   # Owl Carousel initialization
│   └── alpine-config.js # Alpine.js configuration
├── inc/                # Theme functions and includes
├── pages/              # Custom page templates
├── assets/             # Images, icons, and static assets
├── functions.php       # Theme setup and functions
├── header.php          # Header template
├── footer.php          # Footer template
└── style.css           # Theme stylesheet
```

## Customization

### ACF Fields

The theme relies heavily on ACF for content management. Key field groups include:

- **Banner Fields**: Hero images, headings, descriptions, and CTAs
- **Tabbed Sections**: Repeater fields for tabbed content displays
- **FAQs**: Repeater fields with question and answer subfields
- **Testimonials**: Testimonial content management
- **Related Content**: Relationship fields for related posts

### Color Scheme

The theme uses a consistent color palette:

- **Primary Red**: `#DC2626` (red-600) - Primary brand color
- **Gray Scale**: Various gray shades for text and backgrounds
- **Accent Colors**: Used sparingly for highlights and CTAs

### Custom Post Types

- **Services**: Service offerings with custom fields
- **Industries**: Industry-specific content
- **Resources**: Blog posts and resource content

## Development

### Available Commands

```bash
# Compile CSS
npm run build

# Watch for changes
npm run watch

# Lint JavaScript
npm run lint:js

# Lint PHP
composer lint:php
```

### Code Standards

- Follow WordPress Coding Standards for PHP
- Use Tailwind CSS utility classes for styling
- Maintain consistent component structure
- Document complex functionality

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance

The theme is optimized for performance with:

- Lazy loading images
- Optimized asset loading
- Minimal JavaScript footprint
- Efficient CSS delivery
- Caching-friendly structure

## Accessibility

Built with accessibility in mind:

- Semantic HTML structure
- ARIA labels and roles
- Keyboard navigation support
- Screen reader compatibility
- High contrast ratios
- Focus indicators

## Support

For theme support and customization requests, please contact the development team.

## License

This theme is proprietary software developed for Birnbaum Interpreting Services. All rights reserved.

## Credits

- **Design**: Custom design for BIS
- **Framework**: WordPress
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js, Owl Carousel
- **Icons**: Custom SVG icons

## Version

Current version: 1.0.0

---

© 2025 Birnbaum Interpreting Services. All rights reserved.
