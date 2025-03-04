package com.example.demo.dtos;

import lombok.Setter;
import lombok.Getter;
import java.util.List;
import java.util.ArrayList;

@Getter
@Setter
public class PublisherDto {
    private Long id;
    private String name;
    private List<Long> booksIds = new ArrayList<>();

    public PublisherDto(Long id, String name, List<Long> booksIds) {
        this.booksIds = booksIds;
        this.id = id;
        this.name = name;
    }

    public PublisherDto() { }
}
