<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Wishlist - ToyValley</title>
    
    <!-- Add meta tags for better sharing -->
    <meta property="og:title" content="ToyValley Wishlist">
    <meta property="og:description" content="Check out this awesome toy collection on ToyValley">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    
    <!-- Add web app manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    <!-- Add your font -->
    <link href="{{ asset('fonts/VAGRoundedStd-Bold.otf') }}" rel="stylesheet">
    
    <style>
        :root {
            --orange: #FF9052;
            --orange-light: #FFB489;
            --orange-shadow: #FF7A30;
            --background: #F5F5F5;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'VAG Rounded Std', sans-serif;
            background-color: var(--background);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: white;
            padding: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .logo {
            height: 40px;
        }

        .wishlist-title {
            color: var(--orange-shadow);
            margin: 20px 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background-color: #f8f8f8;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            margin: 0;
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }

        .view-button {
            display: inline-block;
            background-color: var(--orange);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.2s;
        }

        .view-button:hover {
            background-color: var(--orange-shadow);
        }

        .app-banner {
            background-color: var(--orange-light);
            padding: 15px;
            border-radius: 12px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
        
        @font-face {
            font-family: 'VAG Rounded Std';
            src: url('{{ asset('fonts/VAGRoundedStd-Bold.otf') }}') format('opentype');
            font-weight: bold;
            font-style: normal;
        }
        
        .deep-link-button {
            background-color: var(--orange);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 10px 0;
        }
        
        .deep-link-button img {
            width: 24px;
            height: 24px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container header-content">
            <img src="{{ asset('logo.svg') }}" alt="ToyValley" class="logo">
        </div>
    </div>

    <div class="container">
        <div class="app-banner">
            <div>
                <h2 style="margin: 0; color: white;">Experience in 3D</h2>
                <p style="margin: 5px 0; color: white;">View these toys in augmented reality</p>
                
            </div>
            <div>
                <a href="https://play.google.com/store/apps/details?id=com.toyvalley.app" target="_blank">
                    <img src="{{ asset('google.svg') }}" alt="Get it on Google Play" style="height: 40px;">
                </a>
                <a href="https://apps.apple.com/app/toyvalley/id123456789" target="_blank">
                    <img src="{{ asset('apple.svg') }}" alt="Download on App Store" style="height: 40px;">
                </a>
            </div>
        </div>

        <h1 class="wishlist-title">Shared Wishlist ({{ count($wishlist['products']) }} items)</h1>

        <div class="products-grid">
            @foreach($wishlist['products'] as $product)
                <div class="product-card">
                    <img 
                        src="{{ $product['image'] }}" 
                        alt="{{ $product['name'] }}" 
                        class="product-image"
                        loading="lazy"
                    >
                    <div class="product-info">
                        <h3 class="product-name">{{ $product['name'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Handle deep linking
        document.addEventListener('DOMContentLoaded', function() {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isAndroid = /Android/.test(navigator.userAgent);
            
            function handleDeepLink(e) {
                e.preventDefault();
                const deepLink = e.target.href;
                
                if (isIOS || isAndroid) {
                    // Try to open the app
                    window.location.href = deepLink;
                    
                    // If app is not installed, redirect to store after timeout
                    setTimeout(() => {
                        if (isIOS) {
                            window.location.href = 'https://apps.apple.com/app/toyvalley/id123456789';
                        } else if (isAndroid) {
                            window.location.href = 'https://play.google.com/store/apps/details?id=com.toyvalley.app';
                        }
                    }, 2500);
                } else {
                    // On desktop, show QR code or prompt to use mobile device
                    alert('Please open this link on your mobile device to view in 3D');
                }
            }
            
            // Add click handlers to all deep links
            document.querySelectorAll('a[href^="toyvalley://"]').forEach(link => {
                link.addEventListener('click', handleDeepLink);
            });
        });
    </script>
</body>
</html>
