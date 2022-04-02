/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.gui;

import com.codename1.components.SpanLabel;
import com.codename1.ui.Container;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.layouts.BoxLayout;
import com.mycompany.myapp.entities.TypeHebergement;
import com.mycompany.myapp.services.ServiceTypeHebergement;
import java.util.ArrayList;
import com.codename1.io.JSONParser;
import com.codename1.ui.Button;
import com.codename1.ui.Dialog;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.plaf.Style;
import com.mycompany.myapp.services.ServiceProprietaire;
import com.mycompany.myapp.gui.UpdateTypeHebergement;
/**
 *
 * @author HPOMEN-I7-1TR
 */
public class ListTypeHebergement extends Form {
        public ListTypeHebergement(Form previous) {
       setTitle("List Types Hebergement");
       setLayout(BoxLayout.y());
       
       ArrayList<TypeHebergement> types = ServiceTypeHebergement.getInstance().getAllTypesHbrg();

         for ( TypeHebergement t : types){
            Container cn = new Container(BoxLayout.y());
            Container cnId = new Container(BoxLayout.x());
            Container cnNom = new Container(BoxLayout.x());
            
            Label id = new Label("id :" )  ;
            Label idg = new Label(String.valueOf(t.getId()));
            Label nom = new Label("nom type : " );
            Label nomg = new Label(t.getNom_type_hbrg());
            Label line = new Label ("-------------------------------------");

            Button btnsupprimer = new Button ("supprimer");
            btnsupprimer.addActionListener(new ActionListener ()  {
               @Override
                        public void actionPerformed(ActionEvent evt){       
                            ServiceTypeHebergement.getInstance().deleteType(t.getId());
              } 
            });            
            
            cnId.add(id);
            cnId.add(idg);
            cnNom.add(nom);
            cnNom.add(nomg);
            cn.add(cnId);
            cn.add(cnNom);
            cn.add(btnsupprimer);

            
            
         //supprimer button
        Label lSupprimer = new Label(" ");
        lSupprimer.setUIID("NewsTopLine");
        Style supprmierStyle = new Style(lSupprimer.getUnselectedStyle());
        supprmierStyle.setFgColor(0xf21f1f);
        
        FontImage suprrimerImage = FontImage.createMaterial(FontImage.MATERIAL_DELETE, supprmierStyle);
        lSupprimer.setIcon(suprrimerImage);
        lSupprimer.setTextPosition(RIGHT);
        
        //click delete icon
        lSupprimer.addPointerPressedListener(l -> {
            
            Dialog dig = new Dialog("Suppression");
            
            if(dig.show("Suppression","Vous voulez supprimer ce reclamation ?","Annuler","Oui")) {
                dig.dispose();
            }
            else {
                dig.dispose();
               }

            if(ServiceTypeHebergement.getInstance().deleteType(t.getId())) {
                    new ListTypeHebergement(previous).show();
                }
           
        });
        
        
        //Update icon 
        Label lModifier = new Label(" ");
        lModifier.setUIID("NewsTopLine");
        Style modifierStyle = new Style(lModifier.getUnselectedStyle());
        modifierStyle.setFgColor(0xf7ad02);
        
        FontImage mFontImage = FontImage.createMaterial(FontImage.MATERIAL_MODE_EDIT, modifierStyle);
        lModifier.setIcon(mFontImage);
        lModifier.setTextPosition(LEFT);
        
        
        lModifier.addPointerPressedListener(l -> {
            //System.out.println("hello update");
            new UpdateTypeHebergement(previous ,t).show();
        });
        
        
        cn.add(lSupprimer);
        cn.add(lModifier);
        
                   
            
            
            
            
            
            
            
            add(cn);
            add(line);
         }
       
        //SpanLabel sp = new SpanLabel();
        //sp.setText(ServiceTypeHebergement.getInstance().getAllTypesHbrg().toString());
        //add(sp);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());

        }
}
       
