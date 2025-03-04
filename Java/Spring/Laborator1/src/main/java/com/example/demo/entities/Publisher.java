package com.example.demo.entities;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;
import java.util.ArrayList;
import java.util.List;

@Table(name="publishers")
@Getter
@Setter
@Entity
public class Publisher {
    @Id
    @GeneratedValue(strategy=GenerationType.AUTO)
    private Long id;

    @Column(name="name")
    private String name;

    @OneToMany(mappedBy="publisher", fetch = FetchType.LAZY)
    private List<Book> books = new ArrayList<>();

    public Publisher(String name) {
        this.name = name;
    }
}
