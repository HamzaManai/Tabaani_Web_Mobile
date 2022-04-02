/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.mycompany.myapp.entities.Hebergement;
import com.mycompany.myapp.entities.TypeHebergement;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Map;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class ServiceHebergement {
    

   public ArrayList<Hebergement> Hebergements;
    
    public static ServiceHebergement instance=null;
    public boolean resultOK;
    private ConnectionRequest req;
    
    
 
    private ServiceHebergement() {
         req = new ConnectionRequest();
    }   
    
    public static ServiceHebergement getInstance() {
        if (instance == null) {
            instance = new ServiceHebergement();
        }
        return instance;
    }
    
    
      public ArrayList<Hebergement> parseHebergements(String jsonText){
        try {
            Hebergements=new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> propreitairesListJson = 
               j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            
            List<Map<String,Object>> list = (List<Map<String,Object>>)propreitairesListJson.get("root");
            for(Map<String,Object> obj : list){
                Hebergement p = new Hebergement();
                float id = Float.parseFloat(obj.get("id").toString());
                float prix = Float.parseFloat(obj.get("nbr_place_hbrg").toString());
                float nbr = Float.parseFloat(obj.get("prix_hbrg").toString());
           
                p.setId((int)id);
                p.setPrix_hbrg((int)prix);
                p.setNbr_place_hbrg((int)nbr);
               // p.setDate_hbrg((Date) obj.get("date_hbrg"));
                p.setNom_hbrg(obj.get("nom_hbrg").toString());
                p.setProprietaire(obj.get("proprietaire").toString());
                p.setAdresse_hbrg(obj.get("adresse_hbrg").toString());
                p.setType_hbrg(obj.get("type_hbrg").toString());
                
                //p.setDate_hbrg;
               // p.setImg_hbrg(obj.get("img_hbrg").toString());
                
                Hebergements.add(p);
            }
            
            
        } catch (IOException ex) {
            
        }
        return Hebergements;
    }
      
    
     public ArrayList<Hebergement> getAllHebergements(){
        req = new ConnectionRequest();
        //String url = Statics.BASE_URL+"/proprietaires/";
        String url = Statics.BASE_URL+"mobile/back-office/hebergement/list";
        System.out.println("===>"+url);
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                Hebergements = parseHebergements(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return Hebergements;
    }
    

  
        public boolean addHebergement(Hebergement h) {
        System.out.println(h);
        System.out.println("********");
       String url = Statics.BASE_URL + "mobile/back-office/hebergement/add?nom_hbrg=" + h.getNom_hbrg() +  "&adresse_hbrg=" + h.getAdresse_hbrg() + "&nbr_place_hbrg=" + h.getNbr_place_hbrg()
               + "&prix_hbrg=" + h.getPrix_hbrg() ;
       //String url = Statics.BASE_URL + "back-office/type-hebergement/add";
    
       req.setUrl(url);
       req.setPost(false);
       //req.addArgument("nom Type : ", t.getNom_type_hbrg());
       req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }
    
        
     public boolean deleteHebergement(int t) {
        String url = Statics.BASE_URL + "/mobile/back-office/hebergement/DeleteHebergement?id="+t;
        req.setUrl(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }
            
          
    //Update 
    public boolean modifierHebergement(Hebergement t) {
        String url = Statics.BASE_URL +"mobile/back-office/type-hebergement/updateHebergement?id="+t.getId()+"&nom_hbrg="+t.getNom_hbrg()+"&adresse_hbrg="+t.getAdresse_hbrg()
                +"&nbr_place_hbrg="+t.getNbr_place_hbrg()+"&prix_hbrg="+t.getPrix_hbrg();
        req.setUrl(url);
    
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
        
    }
    
     
            
}
