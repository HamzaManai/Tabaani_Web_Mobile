/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.gui;

import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.mycompany.myapp.entities.TypeHebergement;
import com.mycompany.myapp.services.ServiceTypeHebergement;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class UpdateTypeHebergement extends Form{
    
    public UpdateTypeHebergement(Form previous,TypeHebergement type ) {
        setTitle("Update Accomadation Type");
        setLayout(BoxLayout.y());
        
        TextField tfName = new TextField( type.getNom_type_hbrg() ,"Type Hebergement Name", 20 , TextField.ANY);
        Button btnModifier = new Button("Modifier");
       btnModifier.setUIID("Button");
       
       //Event onclick btnModifer
       
       btnModifier.addPointerPressedListener(l ->   { 
           
       type.setNom_type_hbrg(tfName.getText());

       //appel fonction modfier reclamation men service

            if(ServiceTypeHebergement.getInstance().modifierType(type)) { // if true
                new ListTypeHebergement(previous).show();
            }
        });
       Button btnAnnuler = new Button("Annuler");
       
       btnAnnuler.addActionListener(e -> {
           new ListTypeHebergement(previous).show();
       });
       
        
        addAll(tfName, btnModifier,btnAnnuler);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
                
    }
            

       
}
