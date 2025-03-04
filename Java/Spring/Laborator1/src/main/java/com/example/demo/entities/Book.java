package com.example.demo.entities;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;
import java.util.List;

@Table(name="books")
@Entity
@Getter
@Setter
public class Book {
    @Id
    @GeneratedValue(strategy=GenerationType.AUTO)
    private Long id;
    private String title;

    @ManyToOne(fetch=FetchType.LAZY)
    @JoinColumn(name="author_id")
    private Author author;

    @ManyToOne(fetch=FetchType.LAZY)
    @JoinColumn(name="publisher_id")
    private Publisher publisher;

    @ManyToMany(fetch=FetchType.LAZY)
    @JoinTable(
            name="book_categories",
            joinColumns=@JoinColumn(name="book_id"),
            inverseJoinColumns=@JoinColumn(name="category_id")
    )
    private List<Category> categories;

    public Book(String title, Author author, Publisher publisher, List<Category> categories){
        this.title = title;
        this.author = author;
        this.publisher = publisher;
        this.categories = categories;
    }
}
