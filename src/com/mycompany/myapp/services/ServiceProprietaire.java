/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.services;
import com.mycompany.myapp.entities.proprietaire;
import com.mycompany.myapp.utils.Statics;
import java.util.ArrayList;
import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.Image;
import java.util.List;
import com.codename1.ui.events.ActionListener;
import com.mycompany.myapp.entities.Hebergement;
import java.io.IOException;
import java.util.Collection;
import java.util.Map;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class ServiceProprietaire {
    
    public ArrayList<proprietaire> Proprietaires;
    
    public static ServiceProprietaire instance=null;
    public boolean resultOK;
    private ConnectionRequest req;
    
    
 
    private ServiceProprietaire() {
         req = new ConnectionRequest();
    }   
    
    public static ServiceProprietaire getInstance() {
        if (instance == null) {
            instance = new ServiceProprietaire();
        }
        return instance;
    }
    
    
        public boolean addProprietaire(proprietaire p) {
        System.out.println(p);
        System.out.println("********");
       String url = Statics.BASE_URL + "mobile/back-office/proprietaire/add?nom_prop=" + p.getNom_prop() +  "&prenom_prop=" + p.getPrenom_prop() + "&email_prop=" + p.getEmail_pop()
               + "&num_tlf_prop=" + p.getNum_tlf_prop() ;
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
    
            
            
    
    
      public ArrayList<proprietaire> parseProprietaires(String jsonText){
        try {
            Proprietaires=new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> propreitairesListJson = 
               j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            
            List<Map<String,Object>> list = (List<Map<String,Object>>)propreitairesListJson.get("root");
            for(Map<String,Object> obj : list){
                proprietaire p = new proprietaire();
                float id = Float.parseFloat(obj.get("id").toString());
                p.setId((int)id);
                p.setNum_tlf_prop(((int)Float.parseFloat(obj.get("num_tlf_prop").toString())));
                p.setNom_prop(obj.get("nom_prop").toString());
                p.setPrenom_prop(obj.get("prenom_prop").toString());
                p.setEmail_pop(obj.get("email_prop").toString());
                p.setHbrgs((Collection<Hebergement>) obj.get("nom_hbrg"));
                p.setImg_prop(obj.get("img_prop").toString());

                Proprietaires.add(p);
            }
            
            
        } catch (IOException ex) {
            
        }
        return Proprietaires;
    }
      
     public ArrayList<proprietaire> getAllProprietaires(){
        req = new ConnectionRequest();
        //String url = Statics.BASE_URL+"/proprietaires/";
        String url = Statics.BASE_URL+"mobile/back-office/proprietaire/list";
        System.out.println("===>"+url);
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                Proprietaires = parseProprietaires(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return Proprietaires;
    }
     
     
     public boolean deleteProprietaire(int t) {
        String url = Statics.BASE_URL + "mobile/back-office/proprietaire/DeleteProprietaire?id="+t;
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
    public boolean modifierProprietaire(proprietaire p) {
        String url = Statics.BASE_URL +"/mobile/back-office/proprietaire/update?id="+p.getId()+"&nom_hbrg="+ p.getNom_prop() +  "&prenom_prop=" + p.getPrenom_prop() + "&email_prop=" + p.getEmail_pop()
               + "&num_tlf_prop=" + p.getNum_tlf_prop() ;
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
