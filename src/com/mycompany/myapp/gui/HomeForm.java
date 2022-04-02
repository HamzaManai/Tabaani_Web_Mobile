/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.gui;
import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class HomeForm extends Form {
    Form current;
    private Resources theme;
//    public HomeForm(Form previous) {

    public HomeForm(Resources theme) {
      /*  
        Toolbar tb= getToolbar();
        Image icon = theme.getImage("TabaaniLogo.png")  ;
Container topBar = BorderLayout.east(new Label(icon));
topBar.add(BorderLayout.SOUTH, new Label("Taabani", "SidemenuTagline"));
topBar.setUIID("SideCommand");
tb.addComponentToSideMenu(topBar);

tb.addMaterialCommandToSideMenu("Home", FontImage.MATERIAL_HOME, e -> {}); 
tb.addMaterialCommandToSideMenu("Add Proprietaire", FontImage.MATERIAL_ADD, e -> {});
tb.addMaterialCommandToSideMenu("List Proprietaires", FontImage.MATERIAL_LIST, e -> {});
tb.addMaterialCommandToSideMenu("Add Type Hebergement", FontImage.MATERIAL_ADD, e -> {});
tb.addMaterialCommandToSideMenu("List Types Hebergement", FontImage.MATERIAL_LIST, e -> {});
tb.addMaterialCommandToSideMenu("Add Hebergement", FontImage.MATERIAL_ADD, e -> {});
tb.addMaterialCommandToSideMenu("List Hebergements", FontImage.MATERIAL_LIST, e -> {});
*/

current=this; //Back 
        setTitle("Home");
        setLayout(BoxLayout.y());
         
        Image profilePic = theme.getImage("tabaani-logo.png");
        Image mask = theme.getImage("round-mask.png");
      //  profilePic = profilePic.fill(mask.getWidth(), mask.getHeight());
       // Label profilePicLabel = new Label(profilePic, "ProfilePic");
       // profilePicLabel.setMask(mask.createMask());
               
        add(new Label("Choose an option"));
        Button btnAddProp = new Button("Add Proprietaire");
        Button btnListProp = new Button("List Proprietaires");
      
        Button btnAddTypeHbrg = new Button("Add Type Hebergement");
        Button btnListTypeHbrg = new Button("List Types Hebegements"); 
        
        Button btnAddHbrg = new Button("Add Hebergement");
        Button btnListHbrg = new Button("List Hebergements");
        
  
        
        btnListProp.addActionListener(e-> new ListProprietaire(current).show());
        btnAddProp.addActionListener(e-> new AddProprietaire(current).show());

        btnListTypeHbrg.addActionListener(e-> new ListTypeHebergement(current).show());
        btnAddTypeHbrg.addActionListener(e-> new AddTypeHebergement(current).show());

        btnListHbrg.addActionListener(e-> new ListHebergement(current).show());
        btnAddHbrg.addActionListener(e-> new AddHebergement(current).show());

        Container by = BoxLayout.encloseY(
               // new Label("Welcome To Tabaani !", "WelcomeWhite"),
                
            btnAddProp,btnListProp,btnAddTypeHbrg,btnListTypeHbrg,btnAddHbrg,btnListHbrg           
        );
        addAll(by);
        
        
    }
    
    

}
