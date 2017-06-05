<?php

add_action( 'init', 'of_options' );
if ( ! function_exists( 'of_options' ) ) {
	function of_options() {
		//Access the WordPress Categories via an Array
		$of_categories     = array();
		$of_categories_obj = get_categories( 'hide_empty=0' );
		foreach ( $of_categories_obj as $of_cat ) {
			$of_categories[ $of_cat->cat_ID ] = $of_cat->cat_name;
		}
		$categories_tmp = array_unshift( $of_categories, "Select a category:" );

		//Access the WordPress Pages via an Array
		$of_pages     = array();
		$of_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
		foreach ( $of_pages_obj as $of_page ) {
			$of_pages[ $of_page->ID ] = $of_page->post_name;
		}
		$of_pages_tmp = array_unshift( $of_pages, "Select a page:" );

		//Testing
		$of_options_select = array( "one", "two", "three", "four", "five" );
		$of_options_radio  = array(
			"one"   => "One",
			"two"   => "Two",
			"three" => "Three",
			"four"  => "Four",
			"five"  => "Five"
		);

		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		(
			"disabled" => array(
				"placebo"     => "placebo", //REQUIRED!
				"block_one"   => "Block One",
				"block_two"   => "Block Two",
				"block_three" => "Block Three",
			),
			"enabled"  => array(
				"placebo"    => "placebo", //REQUIRED!
				"block_four" => "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets     = array();

		if ( is_dir( $alt_stylesheet_path ) ) {
			if ( $alt_stylesheet_dir = opendir( $alt_stylesheet_path ) ) {
				while ( ( $alt_stylesheet_file = readdir( $alt_stylesheet_dir ) ) !== false ) {
					if ( stristr( $alt_stylesheet_file, ".css" ) !== false ) {
						$alt_stylesheets[] = $alt_stylesheet_file;
					}
				}
			}
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory() . '/images/bg/'; // change this to where you store your bg images
		$bg_images_url  = get_template_directory_uri() . '/images/bg/'; // change this to where you store your bg images
		$bg_images      = array();

		if ( is_dir( $bg_images_path ) ) {
			if ( $bg_images_dir = opendir( $bg_images_path ) ) {
				while ( ( $bg_images_file = readdir( $bg_images_dir ) ) !== false ) {
					if ( stristr( $bg_images_file, ".png" ) !== false || stristr( $bg_images_file, ".jpg" ) !== false ) {
						natsort( $bg_images ); //Sorts the array into a natural order
						$bg_images[] = $bg_images_url . $bg_images_file;
					}
				}
			}
		}


		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/

		//More Options
		$uploads_arr      = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads      = get_option( 'of_uploads' );
		$other_entries    = array(
			"Select a number:",
			"1",
			"2",
			"3",
			"4",
			"5",
			"6",
			"7",
			"8",
			"9",
			"10",
			"11",
			"12",
			"13",
			"14",
			"15",
			"16",
			"17",
			"18",
			"19"
		);
		$body_repeat      = array( "no-repeat", "repeat-x", "repeat-y", "repeat" );
		$body_pos         = array(
			"top left",
			"top center",
			"top right",
			"center left",
			"center center",
			"center right",
			"bottom left",
			"bottom center",
			"bottom right"
		);

		// Image Alignment radio box
		$of_options_thumb_align = array( "alignleft" => "Left", "alignright" => "Right", "aligncenter" => "Center" );

		// Image Links to Options
		$of_options_image_link_to = array( "image" => "The Image", "post" => "The Post" );

		$font_weight = array(
			'normal'  => 'Normal',
			'bold'    => 'Bold',
			'lighter' => 'Lighter',
			'100'     => '100',
			'200'     => '200',
			'300'     => '300',
			'400'     => '400',
			'500'     => '500',
			'600'     => '600',
			'700'     => '700',
			'800'     => '800',
			'900'     => '900',
			'inherit' => 'Inherit'
		);

		$font_style = array(
			'normal'  => 'Normal',
			'italic'  => 'Italic',
			'oblique' => 'Oblique',
			'inherit' => 'Inherit'
		);

		$text_transform = array(
			'capitalize' => 'Capitalize',
			'inherit'    => 'Inherit',
			'lowercase'  => 'Lowercase',
			'none'       => 'None',
			'uppercase'  => 'Uppercase'
		);

		$font_sizes = array(
			'10' => '10',
			'11' => '11',
			'12' => '12',
			'13' => '13',
			'14' => '14',
			'15' => '15',
			'16' => '16',
			'17' => '17',
			'18' => '18',
			'19' => '19',
			'20' => '20',
			'21' => '21',
			'22' => '22',
			'23' => '23',
			'24' => '24',
			'25' => '25',
			'26' => '26',
			'27' => '27',
			'28' => '28',
			'29' => '29',
			'30' => '30',
			'31' => '31',
			'32' => '32',
			'33' => '33',
			'34' => '34',
			'35' => '35',
			'36' => '36',
			'37' => '37',
			'38' => '38',
			'39' => '39',
			'40' => '40',
			'41' => '41',
			'42' => '42',
			'43' => '43',
			'44' => '44',
			'45' => '45',
			'46' => '46',
			'47' => '47',
			'48' => '48',
			'49' => '49',
			'50' => '50',
		);

		$google_fonts = array(
			"0"                        => "Select Font",
			"ABeeZee"                  => "ABeeZee",
			"Abel"                     => "Abel",
			"Abril Fatface"            => "Abril Fatface",
			"Aclonica"                 => "Aclonica",
			"Acme"                     => "Acme",
			"Actor"                    => "Actor",
			"Adamina"                  => "Adamina",
			"Advent Pro"               => "Advent Pro",
			"Aguafina Script"          => "Aguafina Script",
			"Akronim"                  => "Akronim",
			"Aladin"                   => "Aladin",
			"Aldrich"                  => "Aldrich",
			"Alegreya"                 => "Alegreya",
			"Alegreya SC"              => "Alegreya SC",
			"Alex Brush"               => "Alex Brush",
			"Alfa Slab One"            => "Alfa Slab One",
			"Alice"                    => "Alice",
			"Alike"                    => "Alike",
			"Alike Angular"            => "Alike Angular",
			"Allan"                    => "Allan",
			"Allerta"                  => "Allerta",
			"Allerta Stencil"          => "Allerta Stencil",
			"Allura"                   => "Allura",
			"Almendra"                 => "Almendra",
			"Almendra Display"         => "Almendra Display",
			"Almendra SC"              => "Almendra SC",
			"Amarante"                 => "Amarante",
			"Amaranth"                 => "Amaranth",
			"Amatic SC"                => "Amatic SC",
			"Amethysta"                => "Amethysta",
			"Anaheim"                  => "Anaheim",
			"Andada"                   => "Andada",
			"Andika"                   => "Andika",
			"Angkor"                   => "Angkor",
			"Annie Use Your Telescope" => "Annie Use Your Telescope",
			"Anonymous Pro"            => "Anonymous Pro",
			"Antic"                    => "Antic",
			"Antic Didone"             => "Antic Didone",
			"Antic Slab"               => "Antic Slab",
			"Anton"                    => "Anton",
			"Arapey"                   => "Arapey",
			"Arbutus"                  => "Arbutus",
			"Arbutus Slab"             => "Arbutus Slab",
			"Architects Daughter"      => "Architects Daughter",
			"Archivo Black"            => "Archivo Black",
			"Archivo Narrow"           => "Archivo Narrow",
			"Arimo"                    => "Arimo",
			"Arizonia"                 => "Arizonia",
			"Armata"                   => "Armata",
			"Artifika"                 => "Artifika",
			"Arvo"                     => "Arvo",
			"Asap"                     => "Asap",
			"Asset"                    => "Asset",
			"Astloch"                  => "Astloch",
			"Asul"                     => "Asul",
			"Atomic Age"               => "Atomic Age",
			"Aubrey"                   => "Aubrey",
			"Audiowide"                => "Audiowide",
			"Autour One"               => "Autour One",
			"Average"                  => "Average",
			"Average Sans"             => "Average Sans",
			"Averia Gruesa Libre"      => "Averia Gruesa Libre",
			"Averia Libre"             => "Averia Libre",
			"Averia Sans Libre"        => "Averia Sans Libre",
			"Averia Serif Libre"       => "Averia Serif Libre",
			"Bad Script"               => "Bad Script",
			"Balthazar"                => "Balthazar",
			"Bangers"                  => "Bangers",
			"Basic"                    => "Basic",
			"Battambang"               => "Battambang",
			"Baumans"                  => "Baumans",
			"Bayon"                    => "Bayon",
			"Belgrano"                 => "Belgrano",
			"Belleza"                  => "Belleza",
			"BenchNine"                => "BenchNine",
			"Bentham"                  => "Bentham",
			"Berkshire Swash"          => "Berkshire Swash",
			"Bevan"                    => "Bevan",
			"Bigelow Rules"            => "Bigelow Rules",
			"Bigshot One"              => "Bigshot One",
			"Bilbo"                    => "Bilbo",
			"Bilbo Swash Caps"         => "Bilbo Swash Caps",
			"Bitter"                   => "Bitter",
			"Black Ops One"            => "Black Ops One",
			"Bokor"                    => "Bokor",
			"Bonbon"                   => "Bonbon",
			"Boogaloo"                 => "Boogaloo",
			"Bowlby One"               => "Bowlby One",
			"Bowlby One SC"            => "Bowlby One SC",
			"Brawler"                  => "Brawler",
			"Bree Serif"               => "Bree Serif",
			"Bubblegum Sans"           => "Bubblegum Sans",
			"Bubbler One"              => "Bubbler One",
			"Buda"                     => "Buda",
			"Buenard"                  => "Buenard",
			"Butcherman"               => "Butcherman",
			"Butterfly Kids"           => "Butterfly Kids",
			"Cabin"                    => "Cabin",
			"Cabin Condensed"          => "Cabin Condensed",
			"Cabin Sketch"             => "Cabin Sketch",
			"Caesar Dressing"          => "Caesar Dressing",
			"Cagliostro"               => "Cagliostro",
			"Calligraffitti"           => "Calligraffitti",
			"Cambo"                    => "Cambo",
			"Candal"                   => "Candal",
			"Cantarell"                => "Cantarell",
			"Cantata One"              => "Cantata One",
			"Cantora One"              => "Cantora One",
			"Capriola"                 => "Capriola",
			"Cardo"                    => "Cardo",
			"Carme"                    => "Carme",
			"Carrois Gothic"           => "Carrois Gothic",
			"Carrois Gothic SC"        => "Carrois Gothic SC",
			"Carter One"               => "Carter One",
			"Caudex"                   => "Caudex",
			"Cedarville Cursive"       => "Cedarville Cursive",
			"Ceviche One"              => "Ceviche One",
			"Changa One"               => "Changa One",
			"Chango"                   => "Chango",
			"Chau Philomene One"       => "Chau Philomene One",
			"Chela One"                => "Chela One",
			"Chelsea Market"           => "Chelsea Market",
			"Chenla"                   => "Chenla",
			"Cherry Cream Soda"        => "Cherry Cream Soda",
			"Cherry Swash"             => "Cherry Swash",
			"Chewy"                    => "Chewy",
			"Chicle"                   => "Chicle",
			"Chivo"                    => "Chivo",
			"Cinzel"                   => "Cinzel",
			"Cinzel Decorative"        => "Cinzel Decorative",
			"Clicker Script"           => "Clicker Script",
			"Coda"                     => "Coda",
			"Coda Caption"             => "Coda Caption",
			"Codystar"                 => "Codystar",
			"Combo"                    => "Combo",
			"Comfortaa"                => "Comfortaa",
			"Coming Soon"              => "Coming Soon",
			"Concert One"              => "Concert One",
			"Condiment"                => "Condiment",
			"Content"                  => "Content",
			"Contrail One"             => "Contrail One",
			"Convergence"              => "Convergence",
			"Cookie"                   => "Cookie",
			"Copse"                    => "Copse",
			"Corben"                   => "Corben",
			"Courgette"                => "Courgette",
			"Cousine"                  => "Cousine",
			"Coustard"                 => "Coustard",
			"Covered By Your Grace"    => "Covered By Your Grace",
			"Crafty Girls"             => "Crafty Girls",
			"Creepster"                => "Creepster",
			"Crete Round"              => "Crete Round",
			"Crimson Text"             => "Crimson Text",
			"Croissant One"            => "Croissant One",
			"Crushed"                  => "Crushed",
			"Cuprum"                   => "Cuprum",
			"Cutive"                   => "Cutive",
			"Cutive Mono"              => "Cutive Mono",
			"Damion"                   => "Damion",
			"Dancing Script"           => "Dancing Script",
			"Dangrek"                  => "Dangrek",
			"Dawning of a New Day"     => "Dawning of a New Day",
			"Days One"                 => "Days One",
			"Delius"                   => "Delius",
			"Delius Swash Caps"        => "Delius Swash Caps",
			"Delius Unicase"           => "Delius Unicase",
			"Della Respira"            => "Della Respira",
			"Denk One"                 => "Denk One",
			"Devonshire"               => "Devonshire",
			"Didact Gothic"            => "Didact Gothic",
			"Diplomata"                => "Diplomata",
			"Diplomata SC"             => "Diplomata SC",
			"Domine"                   => "Domine",
			"Donegal One"              => "Donegal One",
			"Doppio One"               => "Doppio One",
			"Dorsa"                    => "Dorsa",
			"Dosis"                    => "Dosis",
			"Dr Sugiyama"              => "Dr Sugiyama",
			"Droid Sans"               => "Droid Sans",
			"Droid Sans Mono"          => "Droid Sans Mono",
			"Droid Serif"              => "Droid Serif",
			"Duru Sans"                => "Duru Sans",
			"Dynalight"                => "Dynalight",
			"EB Garamond"              => "EB Garamond",
			"Eagle Lake"               => "Eagle Lake",
			"Eater"                    => "Eater",
			"Economica"                => "Economica",
			"Electrolize"              => "Electrolize",
			"Elsie"                    => "Elsie",
			"Elsie Swash Caps"         => "Elsie Swash Caps",
			"Emblema One"              => "Emblema One",
			"Emilys Candy"             => "Emilys Candy",
			"Engagement"               => "Engagement",
			"Englebert"                => "Englebert",
			"Enriqueta"                => "Enriqueta",
			"Erica One"                => "Erica One",
			"Esteban"                  => "Esteban",
			"Euphoria Script"          => "Euphoria Script",
			"Ewert"                    => "Ewert",
			"Exo"                      => "Exo",
			"Expletus Sans"            => "Expletus Sans",
			"Fanwood Text"             => "Fanwood Text",
			"Fascinate"                => "Fascinate",
			"Fascinate Inline"         => "Fascinate Inline",
			"Faster One"               => "Faster One",
			"Fasthand"                 => "Fasthand",
			"Federant"                 => "Federant",
			"Federo"                   => "Federo",
			"Felipa"                   => "Felipa",
			"Fenix"                    => "Fenix",
			"Finger Paint"             => "Finger Paint",
			"Fjalla One"               => "Fjalla One",
			"Fjord One"                => "Fjord One",
			"Flamenco"                 => "Flamenco",
			"Flavors"                  => "Flavors",
			"Fondamento"               => "Fondamento",
			"Fontdiner Swanky"         => "Fontdiner Swanky",
			"Forum"                    => "Forum",
			"Francois One"             => "Francois One",
			"Freckle Face"             => "Freckle Face",
			"Fredericka the Great"     => "Fredericka the Great",
			"Fredoka One"              => "Fredoka One",
			"Freehand"                 => "Freehand",
			"Fresca"                   => "Fresca",
			"Frijole"                  => "Frijole",
			"Fruktur"                  => "Fruktur",
			"Fugaz One"                => "Fugaz One",
			"GFS Didot"                => "GFS Didot",
			"GFS Neohellenic"          => "GFS Neohellenic",
			"Gabriela"                 => "Gabriela",
			"Gafata"                   => "Gafata",
			"Galdeano"                 => "Galdeano",
			"Galindo"                  => "Galindo",
			"Gentium Basic"            => "Gentium Basic",
			"Gentium Book Basic"       => "Gentium Book Basic",
			"Geo"                      => "Geo",
			"Geostar"                  => "Geostar",
			"Geostar Fill"             => "Geostar Fill",
			"Germania One"             => "Germania One",
			"Gilda Display"            => "Gilda Display",
			"Give You Glory"           => "Give You Glory",
			"Glass Antiqua"            => "Glass Antiqua",
			"Glegoo"                   => "Glegoo",
			"Gloria Hallelujah"        => "Gloria Hallelujah",
			"Goblin One"               => "Goblin One",
			"Gochi Hand"               => "Gochi Hand",
			"Gorditas"                 => "Gorditas",
			"Goudy Bookletter 1911"    => "Goudy Bookletter 1911",
			"Graduate"                 => "Graduate",
			"Grand Hotel"              => "Grand Hotel",
			"Gravitas One"             => "Gravitas One",
			"Great Vibes"              => "Great Vibes",
			"Griffy"                   => "Griffy",
			"Gruppo"                   => "Gruppo",
			"Gudea"                    => "Gudea",
			"Habibi"                   => "Habibi",
			"Hammersmith One"          => "Hammersmith One",
			"Hanalei"                  => "Hanalei",
			"Hanalei Fill"             => "Hanalei Fill",
			"Handlee"                  => "Handlee",
			"Hanuman"                  => "Hanuman",
			"Happy Monkey"             => "Happy Monkey",
			"Headland One"             => "Headland One",
			"Henny Penny"              => "Henny Penny",
			"Herr Von Muellerhoff"     => "Herr Von Muellerhoff",
			"Holtwood One SC"          => "Holtwood One SC",
			"Homemade Apple"           => "Homemade Apple",
			"Homenaje"                 => "Homenaje",
			"IM Fell DW Pica"          => "IM Fell DW Pica",
			"IM Fell DW Pica SC"       => "IM Fell DW Pica SC",
			"IM Fell Double Pica"      => "IM Fell Double Pica",
			"IM Fell Double Pica SC"   => "IM Fell Double Pica SC",
			"IM Fell English"          => "IM Fell English",
			"IM Fell English SC"       => "IM Fell English SC",
			"IM Fell French Canon"     => "IM Fell French Canon",
			"IM Fell French Canon SC"  => "IM Fell French Canon SC",
			"IM Fell Great Primer"     => "IM Fell Great Primer",
			"IM Fell Great Primer SC"  => "IM Fell Great Primer SC",
			"Iceberg"                  => "Iceberg",
			"Iceland"                  => "Iceland",
			"Imprima"                  => "Imprima",
			"Inconsolata"              => "Inconsolata",
			"Inder"                    => "Inder",
			"Indie Flower"             => "Indie Flower",
			"Inika"                    => "Inika",
			"Irish Grover"             => "Irish Grover",
			"Istok Web"                => "Istok Web",
			"Italiana"                 => "Italiana",
			"Italianno"                => "Italianno",
			"Jacques Francois"         => "Jacques Francois",
			"Jacques Francois Shadow"  => "Jacques Francois Shadow",
			"Jim Nightshade"           => "Jim Nightshade",
			"Jockey One"               => "Jockey One",
			"Jolly Lodger"             => "Jolly Lodger",
			"Josefin Sans"             => "Josefin Sans",
			"Josefin Slab"             => "Josefin Slab",
			"Joti One"                 => "Joti One",
			"Judson"                   => "Judson",
			"Julee"                    => "Julee",
			"Julius Sans One"          => "Julius Sans One",
			"Junge"                    => "Junge",
			"Jura"                     => "Jura",
			"Just Another Hand"        => "Just Another Hand",
			"Just Me Again Down Here"  => "Just Me Again Down Here",
			"Kameron"                  => "Kameron",
			"Karla"                    => "Karla",
			"Kaushan Script"           => "Kaushan Script",
			"Kavoon"                   => "Kavoon",
			"Keania One"               => "Keania One",
			"Kelly Slab"               => "Kelly Slab",
			"Kenia"                    => "Kenia",
			"Khmer"                    => "Khmer",
			"Kite One"                 => "Kite One",
			"Knewave"                  => "Knewave",
			"Kotta One"                => "Kotta One",
			"Koulen"                   => "Koulen",
			"Kranky"                   => "Kranky",
			"Kreon"                    => "Kreon",
			"Kristi"                   => "Kristi",
			"Krona One"                => "Krona One",
			"La Belle Aurore"          => "La Belle Aurore",
			"Lancelot"                 => "Lancelot",
			"Lato"                     => "Lato",
			"League Script"            => "League Script",
			"Leckerli One"             => "Leckerli One",
			"Ledger"                   => "Ledger",
			"Lekton"                   => "Lekton",
			"Lemon"                    => "Lemon",
			"Libre Baskerville"        => "Libre Baskerville",
			"Life Savers"              => "Life Savers",
			"Lilita One"               => "Lilita One",
			"Limelight"                => "Limelight",
			"Linden Hill"              => "Linden Hill",
			"Lobster"                  => "Lobster",
			"Lobster Two"              => "Lobster Two",
			"Londrina Outline"         => "Londrina Outline",
			"Londrina Shadow"          => "Londrina Shadow",
			"Londrina Sketch"          => "Londrina Sketch",
			"Londrina Solid"           => "Londrina Solid",
			"Lora"                     => "Lora",
			"Love Ya Like A Sister"    => "Love Ya Like A Sister",
			"Loved by the King"        => "Loved by the King",
			"Lovers Quarrel"           => "Lovers Quarrel",
			"Luckiest Guy"             => "Luckiest Guy",
			"Lusitana"                 => "Lusitana",
			"Lustria"                  => "Lustria",
			"Macondo"                  => "Macondo",
			"Macondo Swash Caps"       => "Macondo Swash Caps",
			"Magra"                    => "Magra",
			"Maiden Orange"            => "Maiden Orange",
			"Mako"                     => "Mako",
			"Marcellus"                => "Marcellus",
			"Marcellus SC"             => "Marcellus SC",
			"Marck Script"             => "Marck Script",
			"Margarine"                => "Margarine",
			"Marko One"                => "Marko One",
			"Marmelad"                 => "Marmelad",
			"Marvel"                   => "Marvel",
			"Mate"                     => "Mate",
			"Mate SC"                  => "Mate SC",
			"Maven Pro"                => "Maven Pro",
			"McLaren"                  => "McLaren",
			"Meddon"                   => "Meddon",
			"MedievalSharp"            => "MedievalSharp",
			"Medula One"               => "Medula One",
			"Megrim"                   => "Megrim",
			"Meie Script"              => "Meie Script",
			"Merienda"                 => "Merienda",
			"Merienda One"             => "Merienda One",
			"Merriweather"             => "Merriweather",
			"Merriweather Sans"        => "Merriweather Sans",
			"Metal"                    => "Metal",
			"Metal Mania"              => "Metal Mania",
			"Metamorphous"             => "Metamorphous",
			"Metrophobic"              => "Metrophobic",
			"Michroma"                 => "Michroma",
			"Milonga"                  => "Milonga",
			"Miltonian"                => "Miltonian",
			"Miltonian Tattoo"         => "Miltonian Tattoo",
			"Miniver"                  => "Miniver",
			"Miss Fajardose"           => "Miss Fajardose",
			"Modern Antiqua"           => "Modern Antiqua",
			"Molengo"                  => "Molengo",
			"Molle"                    => "Molle",
			"Monda"                    => "Monda",
			"Monofett"                 => "Monofett",
			"Monoton"                  => "Monoton",
			"Monsieur La Doulaise"     => "Monsieur La Doulaise",
			"Montaga"                  => "Montaga",
			"Montez"                   => "Montez",
			"Montserrat"               => "Montserrat",
			"Montserrat Alternates"    => "Montserrat Alternates",
			"Montserrat Subrayada"     => "Montserrat Subrayada",
			"Moul"                     => "Moul",
			"Moulpali"                 => "Moulpali",
			"Mountains of Christmas"   => "Mountains of Christmas",
			"Mouse Memoirs"            => "Mouse Memoirs",
			"Mr Bedfort"               => "Mr Bedfort",
			"Mr Dafoe"                 => "Mr Dafoe",
			"Mr De Haviland"           => "Mr De Haviland",
			"Mrs Saint Delafield"      => "Mrs Saint Delafield",
			"Mrs Sheppards"            => "Mrs Sheppards",
			"Muli"                     => "Muli",
			"Mystery Quest"            => "Mystery Quest",
			"Neucha"                   => "Neucha",
			"Neuton"                   => "Neuton",
			"New Rocker"               => "New Rocker",
			"News Cycle"               => "News Cycle",
			"Niconne"                  => "Niconne",
			"Nixie One"                => "Nixie One",
			"Nobile"                   => "Nobile",
			"Nokora"                   => "Nokora",
			"Norican"                  => "Norican",
			"Nosifer"                  => "Nosifer",
			"Nothing You Could Do"     => "Nothing You Could Do",
			"Noticia Text"             => "Noticia Text",
			"Noto Sans"                => "Noto Sans",
			"Noto Serif"               => "Noto Serif",
			"Nova Cut"                 => "Nova Cut",
			"Nova Flat"                => "Nova Flat",
			"Nova Mono"                => "Nova Mono",
			"Nova Oval"                => "Nova Oval",
			"Nova Round"               => "Nova Round",
			"Nova Script"              => "Nova Script",
			"Nova Slim"                => "Nova Slim",
			"Nova Square"              => "Nova Square",
			"Numans"                   => "Numans",
			"Nunito"                   => "Nunito",
			"Odor Mean Chey"           => "Odor Mean Chey",
			"Offside"                  => "Offside",
			"Old Standard TT"          => "Old Standard TT",
			"Oldenburg"                => "Oldenburg",
			"Oleo Script"              => "Oleo Script",
			"Oleo Script Swash Caps"   => "Oleo Script Swash Caps",
			"Open Sans"                => "Open Sans",
			"Open Sans Condensed"      => "Open Sans Condensed",
			"Oranienbaum"              => "Oranienbaum",
			"Orbitron"                 => "Orbitron",
			"Oregano"                  => "Oregano",
			"Orienta"                  => "Orienta",
			"Original Surfer"          => "Original Surfer",
			"Oswald"                   => "Oswald",
			"Over the Rainbow"         => "Over the Rainbow",
			"Overlock"                 => "Overlock",
			"Overlock SC"              => "Overlock SC",
			"Ovo"                      => "Ovo",
			"Oxygen"                   => "Oxygen",
			"Oxygen Mono"              => "Oxygen Mono",
			"PT Mono"                  => "PT Mono",
			"PT Sans"                  => "PT Sans",
			"PT Sans Caption"          => "PT Sans Caption",
			"PT Sans Narrow"           => "PT Sans Narrow",
			"PT Serif"                 => "PT Serif",
			"PT Serif Caption"         => "PT Serif Caption",
			"Pacifico"                 => "Pacifico",
			"Paprika"                  => "Paprika",
			"Parisienne"               => "Parisienne",
			"Passero One"              => "Passero One",
			"Passion One"              => "Passion One",
			"Patrick Hand"             => "Patrick Hand",
			"Patrick Hand SC"          => "Patrick Hand SC",
			"Patua One"                => "Patua One",
			"Paytone One"              => "Paytone One",
			"Peralta"                  => "Peralta",
			"Permanent Marker"         => "Permanent Marker",
			"Petit Formal Script"      => "Petit Formal Script",
			"Petrona"                  => "Petrona",
			"Philosopher"              => "Philosopher",
			"Piedra"                   => "Piedra",
			"Pinyon Script"            => "Pinyon Script",
			"Pirata One"               => "Pirata One",
			"Plaster"                  => "Plaster",
			"Play"                     => "Play",
			"Playball"                 => "Playball",
			"Playfair Display"         => "Playfair Display",
			"Playfair Display SC"      => "Playfair Display SC",
			"Podkova"                  => "Podkova",
			"Poiret One"               => "Poiret One",
			"Poller One"               => "Poller One",
			"Poly"                     => "Poly",
			"Pompiere"                 => "Pompiere",
			"Pontano Sans"             => "Pontano Sans",
			"Port Lligat Sans"         => "Port Lligat Sans",
			"Port Lligat Slab"         => "Port Lligat Slab",
			"Prata"                    => "Prata",
			"Preahvihear"              => "Preahvihear",
			"Press Start 2P"           => "Press Start 2P",
			"Princess Sofia"           => "Princess Sofia",
			"Prociono"                 => "Prociono",
			"Prosto One"               => "Prosto One",
			"Puritan"                  => "Puritan",
			"Purple Purse"             => "Purple Purse",
			"Quando"                   => "Quando",
			"Quantico"                 => "Quantico",
			"Quattrocento"             => "Quattrocento",
			"Quattrocento Sans"        => "Quattrocento Sans",
			"Questrial"                => "Questrial",
			"Quicksand"                => "Quicksand",
			"Quintessential"           => "Quintessential",
			"Qwigley"                  => "Qwigley",
			"Racing Sans One"          => "Racing Sans One",
			"Radley"                   => "Radley",
			"Raleway"                  => "Raleway",
			"Raleway Dots"             => "Raleway Dots",
			"Rambla"                   => "Rambla",
			"Rammetto One"             => "Rammetto One",
			"Ranchers"                 => "Ranchers",
			"Rancho"                   => "Rancho",
			"Rationale"                => "Rationale",
			"Redressed"                => "Redressed",
			"Reenie Beanie"            => "Reenie Beanie",
			"Revalia"                  => "Revalia",
			"Ribeye"                   => "Ribeye",
			"Ribeye Marrow"            => "Ribeye Marrow",
			"Righteous"                => "Righteous",
			"Risque"                   => "Risque",
			"Roboto"                   => "Roboto",
			"Roboto Condensed"         => "Roboto Condensed",
			"Roboto Slab"              => "Roboto Slab",
			"Rochester"                => "Rochester",
			"Rock Salt"                => "Rock Salt",
			"Rokkitt"                  => "Rokkitt",
			"Romanesco"                => "Romanesco",
			"Ropa Sans"                => "Ropa Sans",
			"Rosario"                  => "Rosario",
			"Rosarivo"                 => "Rosarivo",
			"Rouge Script"             => "Rouge Script",
			"Ruda"                     => "Ruda",
			"Rufina"                   => "Rufina",
			"Ruge Boogie"              => "Ruge Boogie",
			"Ruluko"                   => "Ruluko",
			"Rum Raisin"               => "Rum Raisin",
			"Ruslan Display"           => "Ruslan Display",
			"Russo One"                => "Russo One",
			"Ruthie"                   => "Ruthie",
			"Rye"                      => "Rye",
			"Sacramento"               => "Sacramento",
			"Sail"                     => "Sail",
			"Salsa"                    => "Salsa",
			"Sanchez"                  => "Sanchez",
			"Sancreek"                 => "Sancreek",
			"Sansita One"              => "Sansita One",
			"Sarina"                   => "Sarina",
			"Satisfy"                  => "Satisfy",
			"Scada"                    => "Scada",
			"Schoolbell"               => "Schoolbell",
			"Seaweed Script"           => "Seaweed Script",
			"Sevillana"                => "Sevillana",
			"Seymour One"              => "Seymour One",
			"Shadows Into Light"       => "Shadows Into Light",
			"Shadows Into Light Two"   => "Shadows Into Light Two",
			"Shanti"                   => "Shanti",
			"Share"                    => "Share",
			"Share Tech"               => "Share Tech",
			"Share Tech Mono"          => "Share Tech Mono",
			"Shojumaru"                => "Shojumaru",
			"Short Stack"              => "Short Stack",
			"Siemreap"                 => "Siemreap",
			"Sigmar One"               => "Sigmar One",
			"Signika"                  => "Signika",
			"Signika Negative"         => "Signika Negative",
			"Simonetta"                => "Simonetta",
			"Sintony"                  => "Sintony",
			"Sirin Stencil"            => "Sirin Stencil",
			"Six Caps"                 => "Six Caps",
			"Skranji"                  => "Skranji",
			"Slackey"                  => "Slackey",
			"Smokum"                   => "Smokum",
			"Smythe"                   => "Smythe",
			"Sniglet"                  => "Sniglet",
			"Snippet"                  => "Snippet",
			"Snowburst One"            => "Snowburst One",
			"Sofadi One"               => "Sofadi One",
			"Sofia"                    => "Sofia",
			"Sonsie One"               => "Sonsie One",
			"Sorts Mill Goudy"         => "Sorts Mill Goudy",
			"Source Code Pro"          => "Source Code Pro",
			"Source Sans Pro"          => "Source Sans Pro",
			"Special Elite"            => "Special Elite",
			"Spicy Rice"               => "Spicy Rice",
			"Spinnaker"                => "Spinnaker",
			"Spirax"                   => "Spirax",
			"Squada One"               => "Squada One",
			"Stalemate"                => "Stalemate",
			"Stalinist One"            => "Stalinist One",
			"Stardos Stencil"          => "Stardos Stencil",
			"Stint Ultra Condensed"    => "Stint Ultra Condensed",
			"Stint Ultra Expanded"     => "Stint Ultra Expanded",
			"Stoke"                    => "Stoke",
			"Strait"                   => "Strait",
			"Sue Ellen Francisco"      => "Sue Ellen Francisco",
			"Sunshiney"                => "Sunshiney",
			"Supermercado One"         => "Supermercado One",
			"Suwannaphum"              => "Suwannaphum",
			"Swanky and Moo Moo"       => "Swanky and Moo Moo",
			"Syncopate"                => "Syncopate",
			"Tangerine"                => "Tangerine",
			"Taprom"                   => "Taprom",
			"Tauri"                    => "Tauri",
			"Telex"                    => "Telex",
			"Tenor Sans"               => "Tenor Sans",
			"Text Me One"              => "Text Me One",
			"The Girl Next Door"       => "The Girl Next Door",
			"Tienne"                   => "Tienne",
			"Tinos"                    => "Tinos",
			"Titan One"                => "Titan One",
			"Titillium Web"            => "Titillium Web",
			"Trade Winds"              => "Trade Winds",
			"Trocchi"                  => "Trocchi",
			"Trochut"                  => "Trochut",
			"Trykker"                  => "Trykker",
			"Tulpen One"               => "Tulpen One",
			"Ubuntu"                   => "Ubuntu",
			"Ubuntu Condensed"         => "Ubuntu Condensed",
			"Ubuntu Mono"              => "Ubuntu Mono",
			"Ultra"                    => "Ultra",
			"Uncial Antiqua"           => "Uncial Antiqua",
			"Underdog"                 => "Underdog",
			"Unica One"                => "Unica One",
			"UnifrakturCook"           => "UnifrakturCook",
			"UnifrakturMaguntia"       => "UnifrakturMaguntia",
			"Unkempt"                  => "Unkempt",
			"Unlock"                   => "Unlock",
			"Unna"                     => "Unna",
			"VT323"                    => "VT323",
			"Vampiro One"              => "Vampiro One",
			"Varela"                   => "Varela",
			"Varela Round"             => "Varela Round",
			"Vast Shadow"              => "Vast Shadow",
			"Vibur"                    => "Vibur",
			"Vidsquareroot"            => "Vidsquareroot",
			"Viga"                     => "Viga",
			"Voces"                    => "Voces",
			"Volkhov"                  => "Volkhov",
			"Vollkorn"                 => "Vollkorn",
			"Voltaire"                 => "Voltaire",
			"Waiting for the Sunrise"  => "Waiting for the Sunrise",
			"Wallpoet"                 => "Wallpoet",
			"Walter Turncoat"          => "Walter Turncoat",
			"Warnes"                   => "Warnes",
			"Wellfleet"                => "Wellfleet",
			"Wendy One"                => "Wendy One",
			"Wire One"                 => "Wire One",
			"Yanone Kaffeesatz"        => "Yanone Kaffeesatz",
			"Yellowtail"               => "Yellowtail",
			"Yeseva One"               => "Yeseva One",
			"Yesteryear"               => "Yesteryear",
			"Zeyada"                   => "Zeyada"
		);


		/*-----------------------------------------------------------------------------------*/
		/* The Options Array */
		/*-----------------------------------------------------------------------------------*/

		// Set the Options Array
		global $of_options;
		$of_options = array();

		$of_options[] = array(
			"name" => "Home Settings",
			"type" => "heading"
		);

		$logo         = get_template_directory_uri() . '/images/logo.png';
		$favicon      = get_template_directory_uri() . '/images/favicon.ico';
		$of_options[] = array(
			"name" => "Header Logo",
			"desc" => "Please choose an image file for your logo.",
			"id"   => "site_logo",
			"std"  => $logo,
			"type" => "media"
		);

		$of_options[] = array(
			"name" => "Favicon",
			"desc" => "You can put url of an ico image that will represent your website's favicon (16px x 16px)",
			"id"   => "favicon",
			"std"  => $favicon,
			"type" => "media"
		);

		$of_options[] = array(
			"name" => "Excerpt Length",
			"desc" => "Input the number of words you want to cut from the content to be the excerpt of search and archive and portfolio page.",
			"id"   => "excerpt_length_blog",
			"std"  => "20",
			"type" => "text"
		);

		$of_options[] = array(
			"name" => "Show Back To Top",
			"desc" => "show/hidden",
			"id"   => "totop_show",
			"std"  => 1,
			"type" => "checkbox"
		);

		$of_options[] = array(
			"name" => "Show preload",
			"desc" => "show/hide",
			"id"   => "show_perload",
			"std"  => 1,
			"type" => "checkbox"
		);

		$of_options[] = array(
			"name" => "Display Post and Page Settings",
			"desc" => "",
			"id"   => "display_settings",
			"std"  => "<h3>Display Post and Page Settings</h3>",
			"icon" => true,
			"type" => "info"
		);

		$of_options[] = array(
			"name" => "Custom Heading Background",
			"id"   => "custom_header_background",
			"type" => "media"
		);

		$of_options[] = array(
			"name" => "Archive Meta Information",
			"desc" => "",
			"id"   => "archiver_info",
			"std"  => "<h3>Archive Meta Information</h3>",
			"icon" => true,
			"type" => "info"
		);
		$of_options[] = array(
			"name" => "Show category",
			"desc" => "show/hidden",
			"id"   => "show_category",
			"std"  => 0,
			"type" => "checkbox"
		);
		$of_options[] = array(
			"name" => "Show date",
			"desc" => "show/hidden",
			"id"   => "show_date",
			"std"  => 1,
			"type" => "checkbox"
		);
		$of_options[] = array(
			"name" => "Show Author",
			"desc" => "show/hidden",
			"id"   => "show_author",
			"std"  => 1,
			"type" => "checkbox"
		);
		$of_options[] = array(
			"name" => "Show Comment ",
			"desc" => "show/hidden",
			"id"   => "show_comment",
			"std"  => 1,
			"type" => "checkbox"
		);

		$of_options[] = array(
			"name" => "Date Format",
			"desc" => "<a href='http://codex.wordpress.org/Formatting_Date_and_Time'>Formatting Date and Time</a>",
			"id"   => "date_format",
			"std"  => "M j",
			"type" => "text"
		);
		//General Settings
		$of_options[] = array(
			"name" => "Header Options",
			"type" => "heading"
		);

		$of_options[] = array(
			"name" => "Header Info",
			"desc" => "",
			"id"   => "header_info",
			"std"  => "<h3>Header Layout Options</h3>",
			"icon" => true,
			"type" => "info"
		);
		$of_options[] = array(
			"name"    => "Select a Header Layout",
			"desc"    => "",
			"id"      => "header_layout",
			"std"     => "header_v1",
			"type"    => "images",
			"options" => array(
				"header_v1" => get_template_directory_uri() . "/images/patterns/header1.jpg",
				"header_v2" => get_template_directory_uri() . "/images/patterns/header2.jpg",
				"header_v3" => get_template_directory_uri() . "/images/patterns/header3.jpg",
			)
		);
		/**
		 * start Squareroottheme
		 * Area setting sidebar
		 * Number sidebar and size foreach sidebar
		 */
		$of_options[] = array(
			"name" => "Archive Options",
			"type" => "heading"
		);
		$url          = ADMIN_DIR . 'assets/images/';
		$of_options[] = array(
			"name"    => "Archive Layout",
			"desc"    => "Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.",
			"id"      => "layout",
			"std"     => "2c-l-fixed",
			"type"    => "images",
			"options" => array(
				'1col-fixed' => $url . '1col.png',
				'2c-r-fixed' => $url . '2cr.png',
				'2c-l-fixed' => $url . '2cl.png',
				'3c-fixed'   => $url . '3cm.png',
				'3c-r-fixed' => $url . '3cr.png',
				'3c-l-fixed' => $url . '3cl.png'
			)
		);
		$of_options[] = array(
			"name" => "Sidebar-a width colums",
			"desc" => "Set width of sidebar-a follow colums bootstrap.",
			"id"   => "sidebar-a-width",
			"std"  => "3",
			"min"  => "1",
			"step" => "1",
			"max"  => "12",
			"type" => "sliderui"
		);
		$of_options[] = array(
			"name" => "Sidebar-b width colums",
			"desc" => "Set width of sidebar-b follow colums bootstrap.",
			"id"   => "sidebar-b-width",
			"std"  => "3",
			"min"  => "1",
			"step" => "1",
			"max"  => "12",
			"type" => "sliderui"
		);
		/**
		 * end Squareroottheme
		 */
		$of_options[] = array(
			"name" => "Page/Post Options",
			"type" => "heading",
			"icon" => ADMIN_IMAGES . "icon-header.png"
		);
		$url          = ADMIN_DIR . 'assets/images/';
		$of_options[] = array(
			"name"    => "Page/Post Layout",
			//"desc"    => "Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.",
			"id"      => "pp_layout",
			"std"     => "2c-l-fixed",
			"type"    => "images",
			"options" => array(
				'1col-fixed' => $url . '1col.png',
				'2c-r-fixed' => $url . '2cr.png',
				'2c-l-fixed' => $url . '2cl.png',
			)
		);

		$of_options[] = array(
			"name" => "Footer Options",
			"type" => "heading"
		);
		$of_options[] = array(
			"name" => "Footer text color ",
			"desc" => "Pick a text color for Footer",
			"id"   => "text_footer_color",
			"std"  => "#FFFFFF",
			"type" => "color"
		);

		$of_options[] = array(
			"name" => "Footer background color",
			"desc" => "Pick a background color.",
			"id"   => "bg_footer_color",
			"std"  => "#151d2a",
			"type" => "color"
		);

		$of_options[] = array(
			"name" => "Copyright Text",
			"desc" => "You can use in your footer text<br/> [Y] Year shortcode",
			"id"   => "footer_text",
			"std"  => "&copy; [Y] Square Root &#8226; Built by ThimPress.",
			"type" => "textarea"
		);

		// typofraphy
		$of_options[] = array(
			"name" => "Typography",
			"type" => "heading"
		);

		$of_options[]   = array(
			"name" => "body Info",
			"desc" => "",
			"id"   => "body_info",
			"std"  => "<h3>Body Options</h3>",
			"icon" => true,
			"type" => "info"
		);
		$standard_fonts = array(
			'0'                                                    => 'Select Font',
			'Arial, Helvetica, sans-serif'                         => 'Arial, Helvetica, sans-serif',
			"'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif",
			"'Bookman Old Style', serif"                           => "'Bookman Old Style', serif",
			"'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive",
			"Courier, monospace"                                   => "Courier, monospace",
			"Garamond, serif"                                      => "Garamond, serif",
			"Georgia, serif"                                       => "Georgia, serif",
			"Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
			"'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"Tahoma, Geneva, sans-serif"                           => "Tahoma, Geneva, sans-serif",
			"'Times New Roman', Times, serif"                      => "'Times New Roman', Times, serif",
			"'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif"
		);
		$of_options[]   = array(
			"name"    => "Select Web Standard Fonts",
			"desc"    => "Select a font family for body text. Live this blank to use Google Fonts.",
			"id"      => "standard_body",
			"std"     => "",
			"type"    => "select",
			"options" => $standard_fonts
		);

		$of_options[] = array(
			"name"    => "Select Google Fonts",
			"desc"    => "Select a font family for body text. Live this blank to use Web Standard Fonts.",
			"id"      => "google_body_font",
			"std"     => "Raleway",
			"type"    => "select",
			"options" => $google_fonts
		);

		$of_options[] = array(
			"name"    => "Body Font Size (px)",
			"desc"    => "Default is 14",
			"id"      => "body_font_size",
			"std"     => "14",
			"type"    => "select",
			"options" => $font_sizes
		);
		$of_options[] = array(
			"name"    => "Font Weight",
			"desc"    => "",
			"id"      => "font_weight_body",
			"std"     => "500",
			"type"    => "select",
			"options" => $font_weight
		);
		$of_options[] = array(
			"name" => "Body Text Color",
			"desc" => "Pick a text color for the theme.",
			"id"   => "body_color",
			"std"  => "#5a5a5a",
			"type" => "color"
		);
		$of_options[] = array(
			"name" => "Body Link Color",
			"desc" => "Pick a link color for the theme.",
			"id"   => "body_link_color",
			"std"  => "#151d2a",
			"type" => "color"
		);

		$of_options[] = array(
			"name" => "Headings Info",
			"desc" => "",
			"id"   => "headings_info",
			"std"  => "<h3>Headings Options</h3>",
			"icon" => true,
			"type" => "info"
		);

		$of_options[] = array(
			"name"    => "Select Standards Fonts Family",
			"desc"    => "Select a font family for body text",
			"id"      => "standard_heading",
			"std"     => "",
			"type"    => "select",
			"options" => $standard_fonts
		);

		$of_options[] = array(
			"name"    => "Select Font Family",
			"desc"    => "Select a font family for headings",
			"id"      => "google_headings",
			"std"     => "Raleway",
			"type"    => "select",
			"options" => $google_fonts
		);
		$of_options[] = array(
			"name" => "Fonts Color",
			"desc" => "Pick a text color for the Headings.",
			"id"   => "headings_color",
			"std"  => "#3f3f3f",
			"type" => "color"
		);
		$of_options[] = array(
			"name"  => "Font H1",
			"desc"  => "",
			"id"    => "font_h1",
			"class" => "ds_font",
			"std"   => "Font H1",
			"icon"  => true,
			"type"  => "info"
		);

		$of_options[] = array(
			"name"    => "Font Size (px)",
			"desc"    => "",
			"id"      => "font_size_h1",
			"std"     => "26",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_sizes
		);

		$of_options[] = array(
			"name"    => "Font Weight H1",
			"desc"    => "",
			"id"      => "font_weight_h1",
			"std"     => "600",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_weight
		);
		$of_options[] = array(
			"name"    => "Font Style",
			"desc"    => "",
			"id"      => "font_style_h1",
			"std"     => "normal",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_style
		);

		$of_options[] = array(
			"name"    => "Text Transform",
			"desc"    => "",
			"id"      => "text_transform_h1",
			"std"     => "none",
			"type"    => "select",
			"class"   => "select25",
			"options" => $text_transform
		);

		$of_options[] = array(
			"name"  => "Font H2",
			"desc"  => "",
			"id"    => "font_h2",
			"class" => "ds_font",
			"std"   => "Font H2",
			"icon"  => true,
			"type"  => "info"
		);

		$of_options[] = array(
			"name"    => "Font Size (px)",
			"desc"    => "",
			"id"      => "font_size_h2",
			"std"     => "24",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_sizes
		);

		$of_options[] = array(
			"name"    => "Font Weight H2",
			"desc"    => "",
			"id"      => "font_weight_h2",
			"std"     => "600",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_weight
		);
		$of_options[] = array(
			"name"    => "Font Style",
			"desc"    => "",
			"id"      => "font_style_h2",
			"std"     => "normal",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_style
		);
		$of_options[] = array(
			"name"    => "Text Transform",
			"desc"    => "",
			"id"      => "text_transform_h2",
			"std"     => "none",
			"type"    => "select",
			"class"   => "select25",
			"options" => $text_transform
		);

		$of_options[] = array(
			"name"  => "Font H3",
			"desc"  => "",
			"id"    => "font_h3",
			"class" => "ds_font",
			"std"   => "Font H3",
			"icon"  => true,
			"type"  => "info"
		);

		$of_options[] = array(
			"name"    => "Font Size (px)",
			"desc"    => "",
			"id"      => "font_size_h3",
			"std"     => "22",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_sizes
		);

		$of_options[] = array(
			"name"    => "Font Weight H3",
			"desc"    => "",
			"id"      => "font_weight_h3",
			"std"     => "600",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_weight
		);
		$of_options[] = array(
			"name"    => "Font Style",
			"desc"    => "",
			"id"      => "font_style_h3",
			"std"     => "normal",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_style
		);
		$of_options[] = array(
			"name"    => "Text Transform",
			"desc"    => "",
			"id"      => "text_transform_h3",
			"std"     => "none",
			"type"    => "select",
			"class"   => "select25",
			"options" => $text_transform
		);

		$of_options[] = array(
			"name"  => "Font H4",
			"desc"  => "",
			"id"    => "font_h4",
			"class" => "ds_font",
			"std"   => "Font H4",
			"icon"  => true,
			"type"  => "info"
		);

		$of_options[] = array(
			"name"    => "Font Size (px)",
			"desc"    => "",
			"id"      => "font_size_h4",
			"std"     => "18",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_sizes
		);

		$of_options[] = array(
			"name"    => "Font Weight H4",
			"desc"    => "",
			"id"      => "font_weight_h4",
			"std"     => "600",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_weight
		);
		$of_options[] = array(
			"name"    => "Font Style",
			"desc"    => "",
			"id"      => "font_style_h4",
			"std"     => "normal",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_style
		);
		$of_options[] = array(
			"name"    => "Text Transform",
			"desc"    => "",
			"id"      => "text_transform_h4",
			"std"     => "none",
			"type"    => "select",
			"class"   => "select25",
			"options" => $text_transform
		);
		$of_options[] = array(
			"name"  => "Font H5",
			"desc"  => "",
			"id"    => "font_h5",
			"class" => "ds_font",
			"std"   => "Font H5",
			"icon"  => true,
			"type"  => "info"
		);

		$of_options[] = array(
			"name"    => "Font Size (px)",
			"desc"    => "",
			"id"      => "font_size_h5",
			"std"     => "14",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_sizes
		);

		$of_options[] = array(
			"name"    => "Font Weight H5",
			"desc"    => "",
			"id"      => "font_weight_h5",
			"std"     => "600",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_weight
		);
		$of_options[] = array(
			"name"    => "Font Style",
			"desc"    => "",
			"id"      => "font_style_h5",
			"std"     => "normal",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_style
		);
		$of_options[] = array(
			"name"    => "Text Transform",
			"desc"    => "",
			"id"      => "text_transform_h5",
			"std"     => "none",
			"type"    => "select",
			"class"   => "select25",
			"options" => $text_transform
		);
		$of_options[] = array(
			"name"  => "Font H6",
			"desc"  => "",
			"id"    => "font_h6",
			"class" => "ds_font",
			"std"   => "Font H6",
			"icon"  => true,
			"type"  => "info"
		);

		$of_options[] = array(
			"name"    => "Font Size (px)",
			"desc"    => "",
			"id"      => "font_size_h6",
			"std"     => "12",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_sizes
		);

		$of_options[] = array(
			"name"    => "Font Weight H6",
			"desc"    => "",
			"id"      => "font_weight_h6",
			"std"     => "normal",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_weight
		);
		$of_options[] = array(
			"name"    => "Font Style",
			"desc"    => "",
			"id"      => "font_style_h6",
			"std"     => "normal",
			"type"    => "select",
			"class"   => "select25",
			"options" => $font_style
		);
		$of_options[] = array(
			"name"    => "Text Transform",
			"desc"    => "",
			"id"      => "text_transform_h6",
			"std"     => "none",
			"type"    => "select",
			"class"   => "select25",
			"options" => $text_transform
		);
//		$of_options[] = array(
//			"name" => "Bootstrap Options",
//			"type" => "heading",
//			"icon" => ADMIN_IMAGES . "icon-bootstrap.png"
//		);
//
//		$of_options[] = array(
//			"name"    => "Bootstrap jQuery",
//			"desc"    => "",
//			"id"      => "bootstrap_js",
//			"std"     => "js_cdn",
//			"type"    => "radio",
//			"options" => array(
//				'js_cdn'      => 'Include From CDN',
//				'js_resource' => 'Include From Resource'
//			)
//		);
//		$of_options[] = array(
//			"name"    => "Bootstrap CSS",
//			"desc"    => "",
//			"id"      => "bootstrap_css",
//			"std"     => "css_cdn",
//			"type"    => "radio",
//			"options" => array(
//				'css_cdn'      => 'Include From CDN',
//				'css_resource' => 'Include From Resource'
//			)
//		);
//		$of_options[] = array(
//			"name"    => "Font Awesome",
//			"desc"    => "",
//			"id"      => "font_awesome",
//			"std"     => "font_awesome_cdn",
//			"type"    => "radio",
//			"options" => array(
//				'font_awesome_cdn'      => 'Include From CDN',
//				'font_awesome_resource' => 'Include From Resource'
//			)
//		);
		// css custom
		$of_options[] = array(
			"name" => "Custom CSS",
			"type" => "heading"
		);
		$of_options[] = array(
			"name" => "Custom CSS",
			"desc" => "",
			"id"   => "css_custom",
			"std"  => ".class_custom{}",
			"type" => "textarea"
		);

		$of_options[] = array(
			"name" => "Backup Options",
			"type" => "heading",
			"icon" => ADMIN_IMAGES . "icon-slider.png"
		);

		$of_options[] = array(
			"name" => "Backup and Restore Options",
			"id"   => "of_backup",
			"std"  => "",
			"type" => "backup",
			"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
		);

		$of_options[] = array(
			"name" => "Transfer Theme Options Data",
			"id"   => "of_transfer",
			"std"  => "",
			"type" => "transfer",
			"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
		);


		/* ------------------------------------------------------------------------ */
		/* CONTACT SECTION
		/* ------------------------------------------------------------------------ */

		$of_options[] = array(
			"name" => "Google Map Settings",
			"type" => "heading",
			"icon" => ADMIN_IMAGES . "icon-contact.png"
		);

		$of_options[] = array(
			"name" => "",
			"desc" => "",
			"id"   => "general_heading",
			"std"  => "Google Map Settings",
			"icon" => false,
			"type" => "info"
		);

		$of_options[] = array(
			"name" => "Enable Google Maps",
			"desc" => "Check to enable Google Map",
			"id"   => "rnr_enable_googlemap",
			"std"  => 1,
			"type" => "checkbox"
		);
		$of_options[] = array(
			"name" => "Button color ",
			"desc" => "Pick a color for Button",
			"id"   => "contact_btn_color",
			"std"  => "#151d2a",
			"type" => "color"
		);
		$of_options[] = array(
			"name" => "Button hover color ",
			"desc" => "Pick a color when hover Button",
			"id"   => "contact_btn_hover_color",
			"std"  => "#151d2a",
			"type" => "color"
		);
		$of_options[] = array(
			"name" => "Background color ",
			"desc" => "Pick a Background",
			"id"   => "contact_bg_color",
			"std"  => "#151d2a",
			"type" => "color"
		);

		$of_options[] = array(
			"name" => "Name",
			"desc" => "Enter your Name.",
			"id"   => "rnr_contact_name",
			"std"  => "Johnny Doe",
			"type" => "text"
		);

		$of_options[] = array(
			"name" => "Address",
			"desc" => "Enter your Address.",
			"id"   => "rnr_contact_address",
			"std"  => "New York City Hall",
			"type" => "text"
		);

		$of_options[] = array(
			"name" => "Email",
			"desc" => "Your email.",
			"id"   => "rnr_contact_email",
			"std"  => "your-email@domain.com",
			"type" => "text"
		);

		$of_options[] = array(
			"name" => "Phone",
			"desc" => "Your phone.",
			"id"   => "rnr_contact_phone",
			"std"  => "1234567890",
			"type" => "text"
		);

		$of_options[] = array(
			"name" => "Latitude Position",
			"desc" => "Find your latitude position at <a href='http://itouchmap.com/latlong.html' target='_blank'>http://itouchmap.com/latlong.html </a>",
			"id"   => "rnr_map_lat",
			"std"  => "40.712833",
			"type" => "text"
		);

		$of_options[] = array(
			"name" => "Longitude Position",
			"desc" => "Find your longitude position at <a href='http://itouchmap.com/latlong.html' target='_blank'>http://itouchmap.com/latlong.html </a>",
			"id"   => "rnr_map_lon",
			"std"  => "-74.005823",
			"type" => "text"
		);

		$of_options[] = array(
			"name" => "Upload Logo for map",
			"desc" => "Upload images using the native media uploader, or define the URL directly",
			"id"   => "rnr_map_logo",
			"std"  => '',
			"type" => "media"
		);

		$of_options[] = array(
			"name" => "Map Zoom Value",
			"desc" => "Give Map Zoom value.",
			"id"   => "rnr_map_zoom",
			"std"  => "18",
			"type" => "text"
		);


	}
	//End function: of_options()
}//End chack if function exists: of_options()
?>
