package com.example.demo.services;

import com.example.demo.dtos.BookDto;
import com.example.demo.entities.Book;
import com.example.demo.entities.Author;
import com.example.demo.entities.Publisher;
import com.example.demo.repositories.BookRepository;
import com.example.demo.repositories.AuthorRepository;
import com.example.demo.repositories.PublisherRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import java.util.List;
import java.util.ArrayList;

@Service
public class BookService {
    @Autowired
    private BookRepository bookRepository;
    @Autowired
    private AuthorRepository authorRepository;
    @Autowired
    private PublisherRepository publisherRepository;

    private BookDto mapToDto(Book book) {
        return new BookDto(book.getId(), book.getTitle(), book.getAuthor().getId(), book.getPublisher().getId(), new ArrayList<>());
    }

    private Book mapToEntity(BookDto bookDto) {
        Author author = authorRepository.findById(bookDto.getAuthorId()).orElseThrow(() -> new RuntimeException("Not found."));
        Publisher publisher = publisherRepository.findById(bookDto.getPublisherId()).orElseThrow(() -> new RuntimeException("Not found."));

        return new Book(bookDto.getTitle(), author, publisher, new ArrayList<>());
    }

    public List<BookDto> getAllBooks() {
        List<Book> allBooks = bookRepository.findAll();
        List<BookDto> bookDtos = new ArrayList<>();
        for(Book book : allBooks){
            bookDtos.add(mapToDto(book));
        }
        return bookDtos;
    }

    public BookDto getBookById(Long id) {
        Book book = bookRepository.findById(id).orElseThrow(() -> new RuntimeException("Not found."));
        return mapToDto(book);
    }

    public BookDto createBook(BookDto bookDto) {
        Author author = authorRepository.findById(bookDto.getAuthorId()).orElseThrow(() -> new RuntimeException("Not found."));
        Publisher publisher = publisherRepository.findById(bookDto.getPublisherId()).orElseThrow(() -> new RuntimeException("Not found."));

        Book book = new Book(bookDto.getTitle(), author, publisher, new ArrayList<>());
        Book savedBook = bookRepository.save(book);
        author.getBooks().add(savedBook);
        publisherRepository.save(publisher);

        return mapToDto(savedBook);
    }

    public void deleteBook(Long id) {
        Book book = bookRepository.findById(id).orElseThrow(() -> new RuntimeException("Not found."));
        bookRepository.delete(book);
    }

    public BookDto updateBook(Long id, BookDto bookDto) {
        Author author = authorRepository.findById(bookDto.getId()).orElseThrow(() -> new RuntimeException("Not found."));
        Publisher publisher = publisherRepository.findById(bookDto.getPublisherId()).orElseThrow(() -> new RuntimeException("Not found."));
        Book book = bookRepository.findById(id).orElseThrow(() -> new RuntimeException("Not found."));

        book.setTitle(bookDto.getTitle());
        book.setAuthor(author);
        book.setPublisher(publisher);

        Book updated = bookRepository.save(book);
        return mapToDto(updated);
    }
}
