package com.example.demo.configs;

import com.example.demo.services.AuthorService;
import com.example.demo.services.BookService;
import com.example.demo.services.PublisherService;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

@Configuration
public class serviceConfigs {
    @Bean
    public BookService bookService() {
        return new BookService();
    }

    @Bean
    public AuthorService authorService() {
        return new AuthorService();
    }

    @Bean
    public PublisherService publisherService() { return new PublisherService(); }
}

