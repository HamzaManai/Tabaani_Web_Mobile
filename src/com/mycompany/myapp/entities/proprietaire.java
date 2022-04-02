/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.entities;

import com.codename1.ui.Image;
import com.mycompany.myapp.entities.Hebergement;
import java.util.Collection;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class proprietaire {
    private int id,num_tlf_prop;
    public String nom_prop,prenom_prop,email_pop,img_prop;
    //private Image img_prop;
    private Collection<Hebergement> hbrgs;


    public proprietaire(int id, int num_tlf_prop, String nom_prop, String prenom_prop, String email_pop, String img_prop, Collection<Hebergement> hbrgs) {
        this.id = id;
        this.num_tlf_prop = num_tlf_prop;
        this.nom_prop = nom_prop;
        this.prenom_prop = prenom_prop;
        this.email_pop = email_pop;
        this.img_prop = img_prop;
        this.hbrgs = hbrgs;
    }

    public proprietaire() {
        }
    public proprietaire( int num_tlf_prop, String nom_prop, String prenom_prop, String email_pop) {
		//this.id = id;
		this.num_tlf_prop = num_tlf_prop;
		this.nom_prop = nom_prop;
		this.prenom_prop= prenom_prop;
                this.email_pop= email_pop;
                //this.img_prop= img_prop;
               
        }
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public int getNum_tlf_prop() {
		return num_tlf_prop;
	}
	public void setNum_tlf_prop(int num_tlf_prop) {
		this.num_tlf_prop = num_tlf_prop;
	}
	public String getNom_prop() {
		return nom_prop;
	}
	public void setNom_prop(String nom_prop) {
		this.nom_prop = nom_prop;
	}
	public String getPrenom_prop() {
		return prenom_prop;
	}
	public void setPrenom_prop(String prenom_prop) {
		this.prenom_prop= prenom_prop;
	}
	public String getEmail_pop() {
		return email_pop;
	}
	public void setEmail_pop(String email_pop) {
		this.email_pop = email_pop;
	}
	public String getImg_prop() {
		return img_prop;
	}
	public void setImg_prop(String img_prop) {
		this.img_prop = img_prop;
	}
        
    public Collection<Hebergement> getHbrgs() {
        return hbrgs;
    }

    public void setHbrgs(Collection<Hebergement> hbrgs) {
        this.hbrgs = hbrgs;
    }

	@Override
	public String toString() {
		return  nom_prop + prenom_prop ;
	}

    
    
    
}
