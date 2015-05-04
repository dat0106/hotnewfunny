<?php

/**
 * Used For retrieving Google fonts list.
 * Also contain some helper functions for general usage
 */
class BF_Google_Fonts_Helper {

    /**
     * Contain array of all Google Fonts List
     * @var array
     */
    private static $google_fonts_list = null;


    /**
     * Used for Retrieving list of all Google Fonts
     */
    public static function get_all_fonts(){

        if( self::$google_fonts_list != null ){
            return self::$google_fonts_list;
        }


        // todo add groups for separating fonts like Sans and Serifs
        return self::$google_fonts_list = json_decode( '{
    "ABeeZee": {
        "variants": [
            {"id": "400", "name": "Normal 400"},
            {"id": "400italic", "name": "Normal 400 Italic"}
        ], "subsets": [
            {"id": "latin", "name": "Latin"}
        ]
    }, "Abel": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Abril Fatface": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Aclonica": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Acme": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Actor": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Adamina": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Advent Pro": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "greek", "name": "Greek"}
    ]
}, "Aguafina Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Akronim": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Aladin": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Aldrich": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Alef": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Alegreya": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Alegreya SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Alegreya Sans": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "700", "name": "Bold 700"},
        {"id": "800", "name": "Extra-Bold 800"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "100italic", "name": "Ultra-Light 100 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "500italic", "name": "Medium 500 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "800italic", "name": "Extra-Bold 800 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Alegreya Sans SC": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "700", "name": "Bold 700"},
        {"id": "800", "name": "Extra-Bold 800"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "100italic", "name": "Ultra-Light 100 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "500italic", "name": "Medium 500 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "800italic", "name": "Extra-Bold 800 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Alex Brush": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Alfa Slab One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Alice": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Alike": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Alike Angular": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Allan": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Allerta": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Allerta Stencil": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Allura": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Almendra": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Almendra Display": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Almendra SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Amarante": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Amaranth": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Amatic SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Amethysta": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Anaheim": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Andada": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Andika": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Angkor": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Annie Use Your Telescope": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Anonymous Pro": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Antic": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Antic Didone": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Antic Slab": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Anton": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Arapey": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Arbutus": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Arbutus Slab": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Architects Daughter": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Archivo Black": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Archivo Narrow": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Arimo": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Arizonia": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Armata": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Artifika": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Arvo": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Asap": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Asset": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Astloch": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Asul": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Atomic Age": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Aubrey": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Audiowide": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Autour One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Average": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Average Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Averia Gruesa Libre": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Averia Libre": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Averia Sans Libre": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Averia Serif Libre": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Bad Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Balthazar": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Bangers": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Basic": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Battambang": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Baumans": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Bayon": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Belgrano": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Belleza": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "BenchNine": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Bentham": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Berkshire Swash": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Bevan": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Bigelow Rules": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Bigshot One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Bilbo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Bilbo Swash Caps": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Bitter": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Black Ops One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Bokor": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Bonbon": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Boogaloo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Bowlby One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Bowlby One SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Brawler": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Bree Serif": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Bubblegum Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Bubbler One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Buda": {
    "variants": [
        {"id": "300", "name": "Book 300"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Buenard": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Butcherman": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Butterfly Kids": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Cabin": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "500italic", "name": "Medium 500 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cabin Condensed": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cabin Sketch": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Caesar Dressing": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cagliostro": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Calligraffitti": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cambo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Candal": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cantarell": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cantata One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Cantora One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Capriola": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Cardo": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"}
    ]
}, "Carme": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Carrois Gothic": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Carrois Gothic SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Carter One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Caudex": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"}
    ]
}, "Cedarville Cursive": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Ceviche One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Changa One": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Chango": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Chau Philomene One": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Chela One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Chelsea Market": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Chenla": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Cherry Cream Soda": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cherry Swash": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Chewy": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Chicle": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Chivo": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cinzel": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cinzel Decorative": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Clicker Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Coda": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "800", "name": "Extra-Bold 800"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Coda Caption": {
    "variants": [
        {"id": "800", "name": "Extra-Bold 800"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Codystar": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Combo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Comfortaa": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Coming Soon": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Concert One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Condiment": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Content": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Contrail One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Convergence": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cookie": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Copse": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Corben": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Courgette": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Cousine": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Coustard": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Covered By Your Grace": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Crafty Girls": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Creepster": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Crete Round": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Crimson Text": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Croissant One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Crushed": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Cuprum": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Cutive": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Cutive Mono": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Damion": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Dancing Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Dangrek": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Dawning of a New Day": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Days One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Delius": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Delius Swash Caps": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Delius Unicase": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Della Respira": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Denk One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Devonshire": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Didact Gothic": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Diplomata": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Diplomata SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Domine": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Donegal One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Doppio One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Dorsa": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Dosis": {
    "variants": [
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "800", "name": "Extra-Bold 800"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Dr Sugiyama": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Droid Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Droid Sans Mono": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Droid Serif": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Duru Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Dynalight": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "EB Garamond": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Eagle Lake": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Eater": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Economica": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Electrolize": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Elsie": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Elsie Swash Caps": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Emblema One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Emilys Candy": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Engagement": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Englebert": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Enriqueta": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Erica One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Esteban": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Euphoria Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Ewert": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Exo": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "800", "name": "Extra-Bold 800"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "100italic", "name": "Ultra-Light 100 Italic"},
        {"id": "200italic", "name": "Light 200 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "500italic", "name": "Medium 500 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "800italic", "name": "Extra-Bold 800 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Exo 2": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "800", "name": "Extra-Bold 800"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "100italic", "name": "Ultra-Light 100 Italic"},
        {"id": "200italic", "name": "Light 200 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "500italic", "name": "Medium 500 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "800italic", "name": "Extra-Bold 800 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Expletus Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "500italic", "name": "Medium 500 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Fanwood Text": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Fascinate": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Fascinate Inline": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Faster One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Fasthand": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Fauna One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Federant": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Federo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Felipa": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Fenix": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Finger Paint": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Fjalla One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Fjord One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Flamenco": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Flavors": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Fondamento": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Fontdiner Swanky": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Forum": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Francois One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Freckle Face": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Fredericka the Great": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Fredoka One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Freehand": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Fresca": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Frijole": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Fruktur": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Fugaz One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "GFS Didot": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "greek", "name": "Greek"}
    ]
}, "GFS Neohellenic": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "greek", "name": "Greek"}
    ]
}, "Gabriela": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Gafata": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Galdeano": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Galindo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Gentium Basic": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Gentium Book Basic": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Geo": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Geostar": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Geostar Fill": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Germania One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Gilda Display": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Give You Glory": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Glass Antiqua": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Glegoo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Gloria Hallelujah": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Goblin One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Gochi Hand": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Gorditas": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Goudy Bookletter 1911": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Graduate": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Grand Hotel": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Gravitas One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Great Vibes": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Griffy": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Gruppo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Gudea": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Habibi": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Hammersmith One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Hanalei": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Hanalei Fill": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Handlee": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Hanuman": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Happy Monkey": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Headland One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Henny Penny": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Herr Von Muellerhoff": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Holtwood One SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Homemade Apple": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Homenaje": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell DW Pica": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell DW Pica SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell Double Pica": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell Double Pica SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell English": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell English SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell French Canon": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell French Canon SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell Great Primer": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "IM Fell Great Primer SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Iceberg": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Iceland": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Imprima": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Inconsolata": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Inder": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Indie Flower": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Inika": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Irish Grover": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Istok Web": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Italiana": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Italianno": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Jacques Francois": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Jacques Francois Shadow": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Jim Nightshade": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Jockey One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Jolly Lodger": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Josefin Sans": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "100italic", "name": "Ultra-Light 100 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Josefin Slab": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "100italic", "name": "Ultra-Light 100 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Joti One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Judson": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Julee": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Julius Sans One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Junge": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Jura": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Just Another Hand": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Just Me Again Down Here": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Kameron": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Kantumruy": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Karla": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Kaushan Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Kavoon": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Kdam Thmor": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Keania One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Kelly Slab": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Kenia": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Khmer": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Kite One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Knewave": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Kotta One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Koulen": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Kranky": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Kreon": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Kristi": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Krona One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "La Belle Aurore": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Lancelot": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Lato": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "100italic", "name": "Ultra-Light 100 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "League Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Leckerli One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Ledger": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Lekton": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Lemon": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Libre Baskerville": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Life Savers": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Lilita One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Lily Script One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Limelight": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Linden Hill": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Lobster": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Lobster Two": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Londrina Outline": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Londrina Shadow": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Londrina Sketch": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Londrina Solid": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Lora": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Love Ya Like A Sister": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Loved by the King": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Lovers Quarrel": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Luckiest Guy": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Lusitana": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Lustria": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Macondo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Macondo Swash Caps": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Magra": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Maiden Orange": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Mako": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Marcellus": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Marcellus SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Marck Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Margarine": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Marko One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Marmelad": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Marvel": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Mate": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Mate SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Maven Pro": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "McLaren": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Meddon": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "MedievalSharp": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Medula One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Megrim": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Meie Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Merienda": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Merienda One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Merriweather": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Merriweather Sans": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "800", "name": "Extra-Bold 800"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "800italic", "name": "Extra-Bold 800 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Metal": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Metal Mania": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Metamorphous": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Metrophobic": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Michroma": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Milonga": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Miltonian": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Miltonian Tattoo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Miniver": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Miss Fajardose": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Modern Antiqua": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Molengo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Molle": {
    "variants": [
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Monda": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Monofett": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Monoton": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Monsieur La Doulaise": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Montaga": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Montez": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Montserrat": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Montserrat Alternates": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Montserrat Subrayada": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Moul": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Moulpali": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Mountains of Christmas": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Mouse Memoirs": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Mr Bedfort": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Mr Dafoe": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Mr De Haviland": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Mrs Saint Delafield": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Mrs Sheppards": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Muli": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Mystery Quest": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Neucha": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Neuton": {
    "variants": [
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "800", "name": "Extra-Bold 800"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "New Rocker": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "News Cycle": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Niconne": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Nixie One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Nobile": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Nokora": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Norican": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Nosifer": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Nothing You Could Do": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Noticia Text": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Noto Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"},
        {"id": "devanagari", "name": "Devanagari"}
    ]
}, "Noto Serif": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Nova Cut": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Nova Flat": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Nova Mono": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"},
        {"id": "greek", "name": "Greek"}
    ]
}, "Nova Oval": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Nova Round": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Nova Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Nova Slim": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Nova Square": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Numans": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Nunito": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Odor Mean Chey": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Offside": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Old Standard TT": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Oldenburg": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Oleo Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Oleo Script Swash Caps": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Open Sans": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "800", "name": "Extra-Bold 800"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "800italic", "name": "Extra-Bold 800 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"},
        {"id": "devanagari", "name": "Devanagari"}
    ]
}, "Open Sans Condensed": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "700", "name": "Bold 700"},
        {"id": "300italic", "name": "Book 300 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Oranienbaum": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Orbitron": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Oregano": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Orienta": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Original Surfer": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Oswald": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Over the Rainbow": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Overlock": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Overlock SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Ovo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Oxygen": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Oxygen Mono": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "PT Mono": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "PT Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "PT Sans Caption": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "PT Sans Narrow": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "PT Serif": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "PT Serif Caption": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Pacifico": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Paprika": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Parisienne": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Passero One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Passion One": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Pathway Gothic One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Patrick Hand": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Patrick Hand SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Patua One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Paytone One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Peralta": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Permanent Marker": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Petit Formal Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Petrona": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Philosopher": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Piedra": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Pinyon Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Pirata One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Plaster": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Play": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Playball": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Playfair Display": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Playfair Display SC": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Podkova": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Poiret One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Poller One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Poly": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Pompiere": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Pontano Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Port Lligat Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Port Lligat Slab": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Prata": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Preahvihear": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Press Start 2P": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"}
    ]
}, "Princess Sofia": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Prociono": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Prosto One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Puritan": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Purple Purse": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Quando": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Quantico": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Quattrocento": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Quattrocento Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Questrial": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Quicksand": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Quintessential": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Qwigley": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Racing Sans One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Radley": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Raleway": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "800", "name": "Extra-Bold 800"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Raleway Dots": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Rambla": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Rammetto One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Ranchers": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Rancho": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Rationale": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Redressed": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Reenie Beanie": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Revalia": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Ribeye": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Ribeye Marrow": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Righteous": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Risque": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Roboto": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "100italic", "name": "Ultra-Light 100 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "500italic", "name": "Medium 500 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Roboto Condensed": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Roboto Slab": {
    "variants": [
        {"id": "100", "name": "Ultra-Light 100"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Rochester": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Rock Salt": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Rokkitt": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Romanesco": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Ropa Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Rosario": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Rosarivo": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Rouge Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Ruda": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Rufina": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Ruge Boogie": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Ruluko": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Rum Raisin": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Ruslan Display": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Russo One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Ruthie": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Rye": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Sacramento": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Sail": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Salsa": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Sanchez": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Sancreek": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Sansita One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Sarina": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Satisfy": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Scada": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Schoolbell": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Seaweed Script": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Sevillana": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Seymour One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Shadows Into Light": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Shadows Into Light Two": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Shanti": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Share": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Share Tech": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Share Tech Mono": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Shojumaru": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Short Stack": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Siemreap": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Sigmar One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Signika": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Signika Negative": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Simonetta": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Sintony": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Sirin Stencil": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Six Caps": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Skranji": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Slackey": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Smokum": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Smythe": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Sniglet": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "800", "name": "Extra-Bold 800"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Snippet": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Snowburst One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Sofadi One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Sofia": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Sonsie One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Sorts Mill Goudy": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Source Code Pro": {
    "variants": [
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Source Sans Pro": {
    "variants": [
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "200italic", "name": "Light 200 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"},
        {"id": "900italic", "name": "Ultra-Bold 900 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Special Elite": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Spicy Rice": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Spinnaker": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Spirax": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Squada One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Stalemate": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Stalinist One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Stardos Stencil": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Stint Ultra Condensed": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Stint Ultra Expanded": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Stoke": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Strait": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Sue Ellen Francisco": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Sunshiney": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Supermercado One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Suwannaphum": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Swanky and Moo Moo": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Syncopate": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Tangerine": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Taprom": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "khmer", "name": "Khmer"}
    ]
}, "Tauri": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Telex": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Tenor Sans": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Text Me One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "The Girl Next Door": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Tienne": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Tinos": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"},
        {"id": "vietnamese", "name": "Vietnamese"}
    ]
}, "Titan One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Titillium Web": {
    "variants": [
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "600", "name": "Semi-Bold 600"},
        {"id": "700", "name": "Bold 700"},
        {"id": "900", "name": "Ultra-Bold 900"},
        {"id": "200italic", "name": "Light 200 Italic"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "600italic", "name": "Semi-Bold 600 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Trade Winds": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Trocchi": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Trochut": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Trykker": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Tulpen One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Ubuntu": {
    "variants": [
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "500", "name": "Medium 500"},
        {"id": "700", "name": "Bold 700"},
        {"id": "300italic", "name": "Book 300 Italic"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "500italic", "name": "Medium 500 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Ubuntu Condensed": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Ubuntu Mono": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"},
        {"id": "greek", "name": "Greek"},
        {"id": "greek-ext", "name": "Greek Extended"},
        {"id": "cyrillic-ext", "name": "Cyrillic Extended"}
    ]
}, "Ultra": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Uncial Antiqua": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Underdog": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Unica One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "UnifrakturCook": {
    "variants": [
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "UnifrakturMaguntia": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Unkempt": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Unlock": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Unna": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "VT323": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Vampiro One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Varela": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Varela Round": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Vast Shadow": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Vibur": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Vidaloka": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Viga": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Voces": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Volkhov": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Vollkorn": {
    "variants": [
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"},
        {"id": "400italic", "name": "Normal 400 Italic"},
        {"id": "700italic", "name": "Bold 700 Italic"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Voltaire": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Waiting for the Sunrise": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Wallpoet": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Walter Turncoat": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Warnes": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Wellfleet": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Wendy One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Wire One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Yanone Kaffeesatz": {
    "variants": [
        {"id": "200", "name": "Light 200"},
        {"id": "300", "name": "Book 300"},
        {"id": "400", "name": "Normal 400"},
        {"id": "700", "name": "Bold 700"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"}
    ]
}, "Yellowtail": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Yeseva One": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin-ext", "name": "Latin Extended"},
        {"id": "latin", "name": "Latin"},
        {"id": "cyrillic", "name": "Cyrillic"}
    ]
}, "Yesteryear": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}, "Zeyada": {
    "variants": [
        {"id": "400", "name": "Normal 400"}
    ], "subsets": [
        {"id": "latin", "name": "Latin"}
    ]
}
}', true );

    }


    /**
     * Used for retrieving single font info
     *
     * @param $font_name
     */
    public static function get_font( $font_name ){

        $fonts =  self::get_all_fonts();

        return $fonts[ $font_name ];

    }


    /**
     * Generate and return Option elements of all font for select element
     *
     * @param string $active_font Family name of selected font in options
     * @param bool $option_group
     * @return string
     */
    public static function get_fonts_family_option_elements( $active_font = '', $option_group = true ){

        $output = '';

        if( $option_group )
            $output .= '<optgroup label="' . __( 'Google Fonts', 'better-studio' ) . '">';

        foreach( self::get_all_fonts() as $key => $font ){
            $output .= '<option value="'. $key .'"' . ( $key == $active_font ? 'selected' : '' ) . '>' .  $key . '</option>';
        }

        if( $option_group )
            $output .= '</optgroup>';

        return $output;

    }


    /**
     * Generate and return Option elements of font variants
     * @param $font
     * @param $active_option
     * @return string
     */
    public static function get_font_variants_option_elements( $font, $active_option ){

        $output = '';

        $font_info =  self::get_font( $font );

        foreach( $font_info['variants'] as $variant ){
            $output .= '<option value="'. $variant['id'] .'"' . ( $variant['id'] == $active_option ? ' selected="selected" ' : '' ) . '>' .  $variant['name'] . '</option>';
        }

        return $output;

    }


    /**
     * Generate and return Option elements of font subsets
     * @param $font
     * @param $active_option
     * @return string
     */
    public static function get_font_subset_option_elements( $font, $active_option ){

        $output = '';

        $font_info =  self::get_font( $font );

        foreach( $font_info['subsets'] as $variant ){
            $output .= '<option value="'. $variant['id'] .'"' . ( $variant['id'] == $active_option ? ' selected="selected" ' : '' ) . '>' .  $variant['name']  . '</option>';
        }

        return $output;

    }


}