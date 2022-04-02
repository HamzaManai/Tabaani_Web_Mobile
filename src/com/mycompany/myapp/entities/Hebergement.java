/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.entities;

import java.util.Date;
import com.mycompany.myapp.entities.TypeHebergement;
import com.mycompany.myapp.entities.proprietaire;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class Hebergement {
    private int id,nbr_place_hbrg,prix_hbrg;
    private String nom_hbrg,adresse_hbrg,img_hbrg;
    private Date date_hbrg;
    public String proprietaire,type_hbrg;
   // public TypeHebergement type_hbrg;
    
    
    public Hebergement() {
    }
    
    public Hebergement(int id, int nbr_place_hbrg, String img_hbrg, String nom_hbrg, String adresse_hbrg, Date date_hbrg, String proprietaire, String type_hbrg, int prix_hbrg) {
        this.id = id;
        this.nbr_place_hbrg = nbr_place_hbrg;
        this.img_hbrg = img_hbrg;
        this.nom_hbrg = nom_hbrg;
        this.adresse_hbrg = adresse_hbrg;
        this.date_hbrg = date_hbrg;
        this.proprietaire = proprietaire;
        this.type_hbrg = type_hbrg;
        this.prix_hbrg = prix_hbrg;
    }
    public Hebergement(int nbr_place_hbrg,int prix_hbrg,String nom_hbrg, String adresse_hbrg) {
        this.nbr_place_hbrg = nbr_place_hbrg;
       // this.img_hbrg = img_hbrg;
        this.nom_hbrg = nom_hbrg;
        this.adresse_hbrg = adresse_hbrg;
       // this.date_hbrg = date_hbrg;
       // this.proprietaire = proprietaire;
       // this.type_hbrg = type_hbrg;
        this.prix_hbrg = prix_hbrg;
    }
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getNbr_place_hbrg() {
        return nbr_place_hbrg;
    }

    public void setNbr_place_hbrg(int nbr_place_hbrg) {
        this.nbr_place_hbrg = nbr_place_hbrg;
    }

    public String getImg_hbrg() {
        return img_hbrg;
    }

    public void setImg_hbrg(String img_hbrg) {
        this.img_hbrg = img_hbrg;
    }

    public String getNom_hbrg() {
        return nom_hbrg;
    }

    public void setNom_hbrg(String nom_hbrg) {
        this.nom_hbrg = nom_hbrg;
    }

    public String getAdresse_hbrg() {
        return adresse_hbrg;
    }

    public void setAdresse_hbrg(String adresse_hbrg) {
        this.adresse_hbrg = adresse_hbrg;
    }

    public Date getDate_hbrg() {
        return date_hbrg;
    }

    public void setDate_hbrg(Date date_hbrg) {
        this.date_hbrg = date_hbrg;
    }

    public String getProprietaire() {
        return proprietaire;
    }

    public void setProprietaire(String proprietaire) {
        this.proprietaire = proprietaire;
    }

    public String getType_hbrg() {
        return type_hbrg;
    }

    public void setType_hbrg(String type_hbrg) {
        this.type_hbrg = type_hbrg;
    }

    public int getPrix_hbrg() {
        return prix_hbrg;
    }

    public void setPrix_hbrg(int prix_hbrg) {
        this.prix_hbrg = prix_hbrg;
    }

    @Override
    public String toString() {
        return "Hebergement{" + "id=" + id + ", nbr_place_hbrg=" + nbr_place_hbrg + ", img_hbrg=" + img_hbrg + ", nom_hbrg=" + nom_hbrg + ", adresse_hbrg=" + adresse_hbrg + ", date_hbrg=" + date_hbrg + ", proprietaire=" + proprietaire + ", type_hbrg=" + type_hbrg + ", prix_hbrg=" + prix_hbrg + '}';
    }

    

}
