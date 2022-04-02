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
import com.codename1.ui.Image;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.mycompany.myapp.entities.proprietaire;
import com.mycompany.myapp.services.ServiceProprietaire;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class AddProprietaire extends Form{
    
    public AddProprietaire(Form previous) {
        setTitle("Add a new Owner");
        setLayout(BoxLayout.y());
        
        TextField tfNom = new TextField("","Owner Last Name : ");
        TextField tfPrenom = new TextField("","Owner First Name : ");
        TextField tfEmail = new TextField("","Owner Email : ",100 ,TextArea.EMAILADDR);
        TextField tfNumTlf = new TextField("","Owner Phone Number : ",8, TextArea.PHONENUMBER);
        Image img = Image.createImage(100, 100);
       
        Button btnValider = new Button("Add Owner");
        
        btnValider.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                if (( tfNom.getText().length()==0) ||(tfPrenom.getText().length()==0) ||
                        (tfEmail.getText().length()==0) || (tfNumTlf.getText().length()==0 ))
                    Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
                else
                {
                    try {
                        proprietaire p = new proprietaire( Integer.parseInt(tfNumTlf.getText()) , tfNom.getText().toString(), tfPrenom.getText() ,
                                                            tfEmail.getText().toString() );
                        if( ServiceProprietaire.getInstance().addProprietaire(p))
                        {
                           Dialog.show("Success","Connection accepted",new Command("OK"));
                        }else
                            Dialog.show("ERROR", "Server error", new Command("OK"));
                    } catch (NumberFormatException e) {
                        Dialog.show("ERROR", "Status must be a number", new Command("OK"));
                    }
                    
                }
                
                
            }

        });
        
        
        addAll(tfNom, tfPrenom, tfEmail, tfNumTlf, btnValider);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
                
    }
    
    
}
