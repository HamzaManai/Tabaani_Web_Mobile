/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.gui;

import com.codename1.ui.Button;
import static com.codename1.ui.Component.RIGHT;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.Style;
import com.mycompany.myapp.entities.Hebergement;
import com.mycompany.myapp.services.ServiceHebergement;
import com.mycompany.myapp.services.ServiceTypeHebergement;
import java.util.ArrayList;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class ListHebergement extends Form {
    
        public ListHebergement(Form previous) {
       setTitle("List Hebergement");
       setLayout(BoxLayout.y());
       
       ArrayList<Hebergement> props =new ArrayList<Hebergement>();

       props = ServiceHebergement.getInstance().getAllHebergements();
        
        for ( Hebergement p : props){
            Container cn = new Container(BoxLayout.y());

            Label id = new Label(" Id :" +  String.valueOf(p.getId())  )  ;

            Label nom = new Label (" Nom : " + p.getNom_hbrg() );
            
            Label type = new Label();
            Label prop = new Label();
            if (p.getType_hbrg() == null ) {
                type = new Label (" Type : " + "-----" );
            }else
               {
                type = new Label (" Type : " + p.getType_hbrg() );
            }

            
            Label adresse = new Label (" Adresse  : " + p.getAdresse_hbrg() );

            //Label date = new Label(" Date :" +  String.valueOf(p.getDate_hbrg())  )  ;

            Label places = new Label ("Nbr Places : " + p.getNbr_place_hbrg() );

            Label prix = new Label (" Prix  : " + p.getPrix_hbrg() );

            if ( p.proprietaire == null ) {
               prop = new Label (" prop : " + "-----" );
            }else
               {
                prop = new Label (" prop : " +  p.proprietaire );            
            }
            /*

            Label img = new Label ("img : " + p.getImg_prop());
            */
                    
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
            
            if(dig.show("Suppression","Are you sure ?","Annuler","Oui")) {
                dig.dispose();
            }
            else {
                dig.dispose();
               }

            if(ServiceHebergement.getInstance().deleteHebergement(p.getId())) {
                    new ListHebergement(previous).show();
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
            new UpdateHebergement(previous ,p).show();
        });
        
            Label line = new Label ("-------------------------------------");
            
            /*
            ImageViewer iv = new ImageViewer();
            try {
            String path;
            path = "/D:/Esprit/pidev/dev github/Apollo/public/uploads/proprietaires/"+ p.getImg_prop();
                Image img = Image.createImage(path);
                iv.setImage(img);
            } catch (IOException ex) {
                System.out.println(ex.getMessage());
            }
            */
            /*
            cnId.add(id);
            cnId.add(idg);
            
            cnNom.add(nom);
            cnNom.add(nomg);
            
            cnPrenom.add(prenom);
            cnPrenom.add(prenomg);
            
            cnEmail.add(email);
            cnEmail.add(emailg);
            
            cnNumTlf.add(num_tlf);
            cnNumTlf.add(num_tlfg);
            
            cn.add(cnId);
            cn.add(cnNom);
            cn.add(cnPrenom);
            cn.add(cnEmail);
            cn.add(cnNumTlf);
            cn.add(img);
            cn.add(btnsupprimer);
            */
            cn.add(id);
            cn.add(nom);
            cn.add(type);
            cn.add(adresse);
            cn.add(places);
            cn.add(prix);
            //cn.add(date);
            cn.add(prop);
            
            cn.add(lSupprimer);
            cn.add(lModifier);
            cn.add(line);
            
            add(cn);
            
            
        }

       /*
       Form hi = new Form("Proprietaires", BoxLayout.y());
       TextField tfId = new TextField("","id" ) ;
       TextField tfNom = new TextField("","nom Proprietaire" ) ;
       TextField tfPrenom = new TextField("","Prenom Proprietaire" ) ;
       TextField tfEmail = new TextField("","email Proprietaire" ) ;
       TextField tfNum = new TextField("","Num telephone Proprietaire" ) ;
       TextField tfImage = new TextField("","Image Proprietaire" ) ;
       
        ArrayList<proprietaire> props =new ArrayList<proprietaire>();

       for ( proprietaire p : props)
       {
            Container cn = new Container(BoxLayout.x());
            /*
            ImageViewer iv = new ImageViewer();
            try {
            String path;
            path = "D:/Esprit/pidev/dev github/Apollo/public/uploads/proprietaires/"+ p.getImg_prop();
                Image img = Image.createImage(path);
                iv.setImage(img);
            } catch (IOException ex) {
                System.out.println(ex.getMessage());
            }
             
         Label nom = new Label(p.getNom_pr*
            
            //cn.add(iv);
            cn.add(nom);
            hi.add(cn);   
            
       }
    */
        //SpanLabel sp = new SpanLabel();
        //sp.setText(ServiceProprietaire.getInstance().getAllPropreitaires().toString());
        //add(sp);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());

       
       // hi.show();
       //getToolbar().addCommandToLeftBar("Back", null, d->{  hi.showBack();  });

    }

}
