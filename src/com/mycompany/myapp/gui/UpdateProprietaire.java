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
import com.mycompany.myapp.entities.proprietaire;
import com.mycompany.myapp.services.ServiceProprietaire;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class UpdateProprietaire extends Form{
    
    public UpdateProprietaire (Form previous,proprietaire prop ){
        
         setTitle("Update Owner");
        setLayout(BoxLayout.y());            
               
         TextField tfNom = new TextField(prop.getNom_prop(),"Owner Last Name : ");
        TextField tfPrenom = new TextField(prop.getPrenom_prop(),"Owner First Name : ");
        TextField tfEmail = new TextField(prop.getEmail_pop(),"Owner Email : ",100 ,TextArea.EMAILADDR);
        TextField tfNumTlf = new TextField(String.valueOf(prop.getNum_tlf_prop()),"Owner Phone Number : ",8, TextArea.PHONENUMBER);       
       Button btnModifier = new Button("Modifier");
       btnModifier.setUIID("Button");        
   //Event onclick btnModifer
       
       btnModifier.addPointerPressedListener(l ->   { 
           
       prop.setNom_prop(tfNom.getText());
       prop.setPrenom_prop(tfPrenom.getText());
       prop.setEmail_pop(tfEmail.getText());
       prop.setNum_tlf_prop(Integer.valueOf( tfNumTlf.getText() ) );

       //appel fonction modfier reclamation men service

            if(ServiceProprietaire.getInstance().modifierProprietaire(prop)) { // if true
                new ListHebergement(previous).show();
            }
        });
       Button btnAnnuler = new Button("Annuler");
       
       btnAnnuler.addActionListener(e -> {
           new ListProprietaire(previous).show();
       });
       
        
        addAll(tfNom,tfPrenom,tfEmail,tfNumTlf, btnModifier,btnAnnuler);        
        
        
        
        
        
    getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());

    }
}
