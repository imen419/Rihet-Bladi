
$(document).ready(function(){
						   
					$("#paragraphe li").click(function(){
													   
//on va cr�er une variable texte qui va nous permette de r�cup�rer la valeur au nivau de css si la paragraphe et cach� ou non 
// on ulilise la valeur children car elle permet de r�cup�rer la valeur de l'�l�ment p = l'enfant de liste non ordonn�e  
						var texte=$(this).children("p");
//si la variable texte est cach� tu me effectu�e plus d'animation sinon tu me effectu�e une autre animation
// 1) si la variable texte est cach� il faut afficher le children p avec l'animation slideDown() en 5OO milliseconde 
										if(texte.is(":hidden"))
													{
														texte.slideDown(300);
							// et pour changer le + en - on utilise cette fonction
														$(this).children("span").html("-");
														}
											else
										          {
											          texte.slideUp();
													  $(this).children("span").html("+");
										        	}
													 
													   });
						   
						  });
						