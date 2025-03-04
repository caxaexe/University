package com.example.demo.entities;

import jakarta.persistence.*;
import lombok.Setter;
import lombok.Getter;
import java.util.List;
import java.util.ArrayList;

@Table(name="libraries")
@Getter
@Setter
@Entity
public class Library {
    @Id
    @GeneratedValue(strategy=GenerationType.AUTO)
    private Long id;

    @Column(name="name")
    private String name;

    @ManyToMany(mappedBy="Libraries", fetch=FetchType.LAZY)
    private List<Long> books = new ArrayList<>();

    public Library(String name, List<Long> books) {
        this.books = books;
        this.name = name;
    }

    public Library() { }
}
