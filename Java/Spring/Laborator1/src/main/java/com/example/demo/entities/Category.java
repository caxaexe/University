package com.example.demo.entities;

import jakarta.persistence.*;
import lombok.Setter;
import lombok.Getter;
import java.util.List;
import java.util.ArrayList;

@Table(name="categories")
@Getter
@Setter
@Entity
public class Category {
    @Id
    @GeneratedValue(strategy=GenerationType.AUTO)
    private Long id;

    @Column(name="name")
    private String name;

    @ManyToMany(mappedBy="category", fetch=FetchType.LAZY)
    private List<Book> books = new ArrayList<>();

    public Category(String name) {
        this.name = name;
    }
}
