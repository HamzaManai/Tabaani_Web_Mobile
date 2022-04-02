/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.gui;

import com.codename1.ui.Button;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.layouts.BoxLayout;
import com.mycompany.myapp.entities.Hebergement;
import com.mycompany.myapp.services.ServiceHebergement;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class UpdateHebergement extends Form {
 
        public UpdateHebergement(Form previous,Hebergement Hbrg ) {

        setTitle("Update Accomadation");
        setLayout(BoxLayout.y());            
        

        TextField nom = new TextField(Hbrg.getNom_hbrg(),"Name : ");
        TextField adresse = new TextField(Hbrg.getAdresse_hbrg(),"Adresse : ");
        TextField prix = new TextField(String.valueOf(Hbrg.getPrix_hbrg()), "Price : ",100 ,TextArea.NUMERIC);
        TextField places = new TextField(String.valueOf(Hbrg.getNbr_place_hbrg()) ,"Number of Places  : ",8, TextArea.PHONENUMBER);
       Button btnModifier = new Button("Modifier");
       btnModifier.setUIID("Button");
       
       //Event onclick btnModifer
       
       btnModifier.addPointerPressedListener(l ->   { 
           
       Hbrg.setNom_hbrg(nom.getText());
       Hbrg.setAdresse_hbrg(adresse.getText());
       Hbrg.setNbr_place_hbrg(Integer.valueOf( places.getText() ) );
       Hbrg.setPrix_hbrg(Integer.valueOf( prix.getText() ) );
       
       //appel fonction modfier reclamation men service

            if(ServiceHebergement.getInstance().modifierHebergement(Hbrg)) { // if true
                new ListHebergement(previous).show();
            }
        });
       Button btnAnnuler = new Button("Annuler");
       
       btnAnnuler.addActionListener(e -> {
           new ListHebergement(previous).show();
       });
       
        
        addAll(nom,adresse,prix,places, btnModifier,btnAnnuler);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
         
        }
}
