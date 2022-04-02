/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.entities;

/**
 *
 * @author HPOMEN-I7-1TR
 */
public class TypeHebergement {
    private int id;
    private String nom_type_hbrg;

    public TypeHebergement() {
    }

    public TypeHebergement(String nom_type_hbrg) {
       // this.id = id;
        this.nom_type_hbrg = nom_type_hbrg;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom_type_hbrg() {
        return nom_type_hbrg;
    }

    public void setNom_type_hbrg(String nom_type_hbrg) {
        this.nom_type_hbrg = nom_type_hbrg;
    }

    @Override
    public String toString() {
        return "TypeHebergement{" + "id=" + id + ", nom_type_hbrg=" + nom_type_hbrg + '}';
    }
    
    
    
}
