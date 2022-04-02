/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.gui;

import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.mycompany.myapp.entities.Hebergement;
import com.mycompany.myapp.entities.TypeHebergement;
import com.mycompany.myapp.services.ServiceHebergement;
import com.mycompany.myapp.services.ServiceTypeHebergement;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.Map;
//import java.util.stream.Collectors;
//import java.util.stream.Stream;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class AddHebergement extends Form {
    
    
        public AddHebergement(Form previous) {
        setTitle("Add a new Accomadation");
        setLayout(BoxLayout.y());
                
        TextField nom = new TextField("","Name : ");
        TextField adresse = new TextField("","Adresse : ");
        TextField prix = new TextField("","Price : ",100 ,TextArea.NUMERIC);
        TextField places = new TextField("","Number of Places  : ",8, TextArea.PHONENUMBER);
        
       ArrayList<TypeHebergement> types = ServiceTypeHebergement.getInstance().getAllTypesHbrg();
      /*
       ArrayList<TypeHebergement> t= types.stream().collect(Collectors.toList());
               -
       ComboBox combo = new ComboBox (                         
                    types.stream().forEach(t-> System.out.println(t))
          );
        */
       
        
        
        Button btnValider = new Button("Add Accomadation");
        
        btnValider.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                if (( nom.getText().length()==0) ||(adresse.getText().length()==0) ||
                        (prix.getText().length()==0) || (places.getText().length()==0 ))
                    Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
                else
                {
                    try {
                        Hebergement h = new Hebergement( Integer.parseInt(prix.getText()),Integer.parseInt(places.getText()) , nom.getText().toString(), adresse.getText() );
                        if( ServiceHebergement.getInstance().addHebergement(h))
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
                
          addAll(nom,adresse,prix,places, btnValider);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
              
        
        
        }
}
