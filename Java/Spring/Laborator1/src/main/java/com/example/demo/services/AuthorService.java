package com.example.demo.services;

import com.example.demo.dtos.AuthorDto;
import com.example.demo.entities.Book;
import com.example.demo.entities.Author;
import com.example.demo.repositories.AuthorRepository;
import com.example.demo.repositories.BookRepository;
import org.springframework.stereotype.Service;
import org.springframework.beans.factory.annotation.Autowired;
import java.util.List;
import java.util.ArrayList;

@Service
public class AuthorService {
    @Autowired
    private AuthorRepository authorRepository;
    @Autowired
    private BookRepository bookRepository;

    private AuthorDto mapToDto(Author author) {
        return new AuthorDto(author.getId(), author.getFirstName(), author.getLastName(), getIds(author));
    }

    private List<Long> getIds(Author author) {
        List<Book> books = author.getBooks();
        List<Long> ids = new ArrayList<>();
        for(var book : books) {
            ids.add(book.getId());
        }
        return ids;
    }

    private Author mapToEntity(AuthorDto authorDto) {
        return new Author(authorDto.getFirstName(), authorDto.getLastName());
    }

    public List<AuthorDto> getAllAuthors() {
        List<Author> authorList = authorRepository.findAll();
        List<AuthorDto> authorDtoList = new ArrayList<>();

        for(Author author : authorList) {
            authorDtoList.add(mapToDto(author));
        }
        return authorDtoList;
    }

    public AuthorDto getAuthorById(Long id) {
        Author author = authorRepository.findById(id).orElseThrow(() -> new RuntimeException("Not found."));
        return mapToDto(author);
    }

    public AuthorDto createAuthor(AuthorDto authorDto) {
        Author author = mapToEntity(authorDto);
        Author savedAuthor = authorRepository.save(author);
        return mapToDto(savedAuthor);
    }

    public AuthorDto updateAuthor(Long id, AuthorDto authorDto) {
        Author author = authorRepository.findById(id).orElseThrow(() -> new RuntimeException("Not found."));
        author.setFirstName(authorDto.getFirstName());
        author.setLastName(authorDto.getLastName());
        if(authorDto.getBooksIds() != null) {
            List<Book> books = bookRepository.findAllById(authorDto.getBooksIds());
            author.setBooks(books);
        }
        Author updated = authorRepository.save(author);
        return mapToDto(updated);
    }

    public void deleteAuthor(Long id) {
        Author author = authorRepository.findById(id).orElseThrow(() -> new RuntimeException("Not found."));
    }
}
