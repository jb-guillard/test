<?php
/**
 * Gestion du widget "widgetFlickr"
 *
 * 
 *
 * @author Jean-Baptiste Guillard <jb.guillard@agence-zephyr.fr>
 *
 * @date 2013-04-03 14:03
 */
class widgetWidgetflickr
{

	/*
	** Class constructor
	*/
	private $_contentZone='';

	/*
	** Class constructor
	*/
	function __construct(){
		
	}

	/*
	** Méthode de retour
	** Cette méthode doit retourner le contenu du widget. Par exemple, si start retourne 'Hello', le contenu du widget sera 'Hello'
	*/
	public function start(){
	
		// d'apres le tutoriel : http://asociaux.fr/post/2011/07/30/lister-images-et-videos-album-flickr
		// avec l'API flickr : http://www.flickr.com/services/api/
	
		// class php pour l'authentification
		require_once(dirname(__file__).'/phpFlickr.php');
		// valeurs a recuperer dans son compte flickr
		$cle_api = 'cbcaeccd437f7dc1448ecbd1463c191a';
		$cle_secret_api = '517c56e810133023';
		$ID_utilisateur	= '99684437@N02';
		// id de la galerie
		$photoset_id = '72157635291922335';
				
		// acces aux données de son compte
		$f = new phpFlickr($cle_api, $cle_secret_api);  
		// utilisation de l'API de flickr avec photosets_getPhotos()
		$photosets_photos = $f->photos_search(array("user_id" => $ID_utilisateur, "per_page" => 3));
		$photosets_photos = $f->photosets_getPhotos($photoset_id, 'date_upload', null, 3, 1, "all");  
		$photosets_photos = $photosets_photos['photoset']; 

		// affichage des photos, utilisation de l'API de flickr avec buildPhotoURL() et des valeurs du tableau $photosets_photos
		// avec ajout d'un lightbox 'FancyBox'
		// le tri est a configurer dans les parametres de la galerie, directement sur le site de flickr
		
		$affich = '<div class="widget widget-flickr"><p class="widget-title"><span class="logo-flickr left t-indent">Flickr</span><span>Photos</span></p><div class="widget-container">';  
		
		foreach ($photosets_photos['photo'] as $photo) {  
			 $affich .= '  
				  <a rel="flickr" class="fancybox item-flickr" href="'.$f->buildPhotoURL($photo, "large").'" title="'.$photo['title'].'">  
					   <img src="'.$f->buildPhotoURL($photo, "square_150").'" alt="'.$photo['title'].'" />  
				  </a>  
			';  
		}  
		$affich .= '<a href="/mediatheque/galerie-photos/" class="all-photos">Toutes les photos</a></div></div>';
		
		return $affich;
	}

	/*
	** Méthode permettant de retourner du contenu à afficher dans la zone de contenu
	**
	*/
	public function getContentZone(){
		return $this->_contentZone;
	}
}