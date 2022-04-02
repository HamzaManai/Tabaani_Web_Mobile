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
import com.mycompany.myapp.entities.TypeHebergement;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class ServiceTypeHebergement {
    
    
    public ArrayList<TypeHebergement> TypeHebergements;
    
    public static ServiceTypeHebergement instance=null;
    public boolean resultOK;
    private ConnectionRequest req;
    
    
 
    private ServiceTypeHebergement() {
         req = new ConnectionRequest();
    }   
    
    public static ServiceTypeHebergement getInstance() {
        if (instance == null) {
            instance = new ServiceTypeHebergement();
        }
        return instance;
    }
    
    
        public boolean addTypeHbrg(TypeHebergement t) {
        System.out.println(t);
        System.out.println("********");
       String url = Statics.BASE_URL + "mobile/back-office/type-hebergement/add?nom_type_hbrg=" + t.getNom_type_hbrg() ;
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
    
    
      public ArrayList<TypeHebergement> parseTypeHebergements(String jsonText){
        try {
            TypeHebergements=new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> propreitairesListJson = 
               j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            
            List<Map<String,Object>> list = (List<Map<String,Object>>)propreitairesListJson.get("root");
            for(Map<String,Object> obj : list){
                TypeHebergement p = new TypeHebergement();
                float id = Float.parseFloat(obj.get("id").toString());
                p.setId((int)id);
                p.setNom_type_hbrg(obj.get("nom_type_hbrg").toString());


                TypeHebergements.add(p);
            }
            
            
        } catch (IOException ex) {
            
        }
        return TypeHebergements;
    }
      
     public ArrayList<TypeHebergement> getAllTypesHbrg(){
        req = new ConnectionRequest();
        //String url = Statics.BASE_URL+"/proprietaires/";
        String url = Statics.BASE_URL+"mobile/back-office/type-hebergement/list";
        System.out.println("===>"+url);
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                TypeHebergements = parseTypeHebergements(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return TypeHebergements;
    }
    

          
     public boolean deleteType(int t) {
        String url = Statics.BASE_URL + "mobile/back-office/type-hebergement/deleteTypeHebergement?id="+t;
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
    public boolean modifierType(TypeHebergement t) {
        String url = Statics.BASE_URL +"mobile/back-office/type-hebergement/updateTypeHebergement?id="+t.getId()+"&nom_type_hbrg="+t.getNom_type_hbrg();
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
