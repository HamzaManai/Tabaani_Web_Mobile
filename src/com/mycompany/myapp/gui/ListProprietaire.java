package com.mycompany.myapp.gui;

import com.codename1.components.ImageViewer;
import com.codename1.components.SpanLabel;
import com.codename1.ui.Button;
import static com.codename1.ui.Component.LEFT;
import static com.codename1.ui.Component.RIGHT;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.FontImage;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.Style;
import com.mycompany.myapp.entities.proprietaire;
import com.mycompany.myapp.services.ServiceProprietaire;
import java.io.IOException;
import java.util.ArrayList;

public class ListProprietaire extends Form {
	
    public ListProprietaire(Form previous) {
       setTitle("List Proprietaire");
       setLayout(BoxLayout.y());
       
       ArrayList<proprietaire> props =new ArrayList<proprietaire>();

       props = ServiceProprietaire.getInstance().getAllProprietaires();
        
        for ( proprietaire p : props){
            Container cn = new Container(BoxLayout.y());
            Container cnId= new Container(BoxLayout.x());
            Container cnNom= new Container(BoxLayout.x());
            Container cnPrenom= new Container(BoxLayout.x());
            Container cnEmail= new Container(BoxLayout.x());
            Container cnNumTlf= new Container(BoxLayout.x());

            Label id = new Label("id :" )  ;
            Label idg = new Label(String.valueOf(p.getId()) )  ;

            Label nom = new Label ("nom : " );
            Label nomg = new Label (p.getNom_prop());

            Label prenom = new Label ("prenom : ");
            Label prenomg = new Label ( p.getPrenom_prop());

            Label email = new Label ("email : ");
            Label emailg = new Label (p.getEmail_pop());

            Label num_tlf = new Label ("numero de telephone : ");
            Label num_tlfg = new Label (String.valueOf(p.getNum_tlf_prop()));
            
            Label imgL = new Label ();
            Label check = new Label ("img : " + p.getImg_prop() );
            Label hbrgmnts = new Label (" Hebergements : " + p.getHbrgs());
                    
            Button btnsupprimer = new Button ("supprimer");
            btnsupprimer.addActionListener(new ActionListener ()  {
               @Override
                        public void actionPerformed(ActionEvent evt){       
                            ServiceProprietaire.getInstance().deleteProprietaire(p.getId());
              } 
            });
            Label line = new Label ("-------------------------------------");
            
            
            ImageViewer iv = new ImageViewer();
            try {
            String path;
            path = "/D:/Esprit/pidev/dev github/Apollo/public/uploads/proprietaires/"+p.getImg_prop();
                       // Label pa = new Label ("path "  + path ) ; 
           // cn.add(pa);
                Image img = Image.createImage(path);
                //iv.setImage(imgL);
                imgL.setIcon(img);
                this.revalidate();
                
            } catch (IOException ex) {
                System.out.println(ex.getMessage());
            }
            
            
            
            
            
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
            
            if(dig.show("Suppression","Are you sure?","Cancel","Yes")) {
                dig.dispose();
            }
            else {
                dig.dispose();
               }

            if(ServiceProprietaire.getInstance().deleteProprietaire(p.getId())) {
                    new ListProprietaire(previous).show();
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
            new UpdateProprietaire(previous ,p).show();
        });
        
            
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
            cn.add(check);
            

            cn.add(imgL);
            cn.add(hbrgmnts);
            cn.add(btnsupprimer);
            
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
