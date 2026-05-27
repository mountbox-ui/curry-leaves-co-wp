from pathlib import Path
path = Path(r'c:\Users\user\Local Sites\curyy-leaves\app\public\wp-content\themes\curry-leaves-co\template-parts\home\specials.php')
text = path.read_text(encoding='utf-8')
text = text.replace(
    "<p class=\"chef-story\"><?php echo esc_html( clc_mod( 'clc_special_story', 'Our executive chef layers buttery pastry with premium grass-fed beef, black truffle, and a red wine reduction — composed for takeaway and finished moments before you collect.' ) ); ?></p>",
    "<p class=\"chef-story\"><?php echo esc_html( $special_story ); ?></p>"
)
text = text.replace(
    "\t\t\t\t\t\t\t\t<div class=\"special-ingredients-list\">\n\t\t\t\t\t\t\t\t\t<?php\n\t\t\t\t\t\t\t\t\t$ings = array( 'Grass-fed beef', 'Black truffle', 'Puff pastry', 'Red wine jus' );\n\t\t\t\t\t\t\t\t\tforeach ( $ings as $ing ) :\n",
    "\t\t\t\t\t\t\t\t<div class=\"special-ingredients-list\">\n\t\t\t\t\t\t\t\t\t<?php\n\t\t\t\t\t\t\t\t\tforeach ( $special_ingredients as $ing ) :\n"
)
text = text.replace(
    "\t\t\t\t\t\t\t\t<div class=\"special-price-row\">\n\t\t\t\t\t\t\t\t\t<span class=\"special-price\">$<?php echo esc_html( clc_mod( 'clc_special_price', '58' ) ); ?></span>\n\t\t\t\t\t\t\t\t\t<a href=\"#order\" class=\"btn-luxury btn-gold\"><?php esc_html_e( 'Order Your Dish', 'curry-leaves-co' ); ?></a>\n\t\t\t\t\t\t\t\t</div>\n",
    "\t\t\t\t\t\t\t\t<div class=\"special-price-row\">\n\t\t\t\t\t\t\t\t\t<?php if ( $special_price ) : ?>\n\t\t\t\t\t\t\t\t\t\t<span class=\"special-price\">$<?php echo esc_html( $special_price ); ?></span>\n\t\t\t\t\t\t\t\t\t<?php endif; ?>\n\t\t\t\t\t\t\t\t\t<a href=\"#order\" class=\"btn-luxury btn-gold\"><?php esc_html_e( 'Order Your Dish', 'curry-leaves-co' ); ?></a>\n\t\t\t\t\t\t\t\t</div>\n"
)
path.write_text(text, encoding='utf-8')
print('patched specials', len(text))
