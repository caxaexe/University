package com.example.demo.dtos;

import lombok.Getter;
import lombok.Setter;
import java.util.List;

@Setter
@Getter
public class BookDto {
    private Long id;
    private String title;
    private Long authorId;
    private Long publisherId;
    private List<Long> categoryIds;

    public BookDto(Long id, String title, Long authorId, Long publisherId, List<Long> categoryIds) {
        this.id = id;
        this.title = title;
        this.authorId = authorId;
        this.publisherId = publisherId;
        this.categoryIds = categoryIds;
    }
}
