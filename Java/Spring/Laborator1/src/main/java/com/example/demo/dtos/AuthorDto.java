package com.example.demo.dtos;

import lombok.Setter;
import lombok.Getter;
import java.util.List;
import java.util.ArrayList;

@Getter
@Setter
public class AuthorDto {
    private Long id;
    private String firstName;
    private String lastName;
    private List<Long> booksIds = new ArrayList<>();

    public AuthorDto(Long id, String firstName, String lastName, List<Long> booksIds) {
        this.id = id;
        this.firstName = firstName;
        this.lastName = lastName;
        this.booksIds = booksIds;
    }

    @Override
    public String toString() {
        return id + firstName + lastName;
    }
}
