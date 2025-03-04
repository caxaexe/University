package com.example.demo.services;

import com.example.demo.dtos.PublisherDto;
import com.example.demo.entities.Book;
import com.example.demo.entities.Publisher;
import com.example.demo.repositories.BookRepository;
import com.example.demo.repositories.PublisherRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import java.util.List;
import java.util.ArrayList;

@Service
public class PublisherService {
    @Autowired
    private PublisherRepository publisherRepository;
    @Autowired
    private BookRepository bookRepository;

    private PublisherDto mapToDto(Publisher publisher) {
        return new PublisherDto(publisher.getId(), publisher.getName(), getIds(publisher));
    }

    private Publisher mapToEntity(PublisherDto publisherDto) {
        return new Publisher(publisherDto.getName());
    }

    private List<Long> getIds(Publisher publisher){
        List<Book> books = publisher.getBooks();
        List<Long> ids = new ArrayList<>();
        for(var book : books) {
            ids.add(book.getId());
        }
        return ids;
    }

    public List<PublisherDto> allPublishers() {
        List<Publisher> publishers = publisherRepository.findAll();
        List<PublisherDto> publisherDtos = new ArrayList<>();
        for(Publisher publisher : publishers){
            publisherDtos.add(mapToDto((publisher)));
        }
        return publisherDtos;
    }

    public PublisherDto createPublisher(PublisherDto publisherDto){
        Publisher publisher = mapToEntity((publisherDto));
        Publisher savedPublisher = publisherRepository.save(publisher);
        return mapToDto(savedPublisher);
    }

    public PublisherDto getPublisherById(Long id){
        Publisher publisher = publisherRepository.findById(id).orElseThrow(() -> new RuntimeException("Not found."));
        return mapToDto(publisher);
    }

    public PublisherDto updatePublisher(Long id, PublisherDto publisherDto) {
        Publisher publisher = publisherRepository.findById(id).orElseThrow(() -> new RuntimeException("Not found."));
        publisher.setName(publisherDto.getName());
        if(publisherDto.getBooksIds() != null){
            List<Book> books = bookRepository.findAllById(publisherDto.getBooksIds());
            publisher.setBooks(books);
        }
        Publisher updated = publisherRepository.save(publisher);
        return mapToDto(updated);
    }

    public void deletePublisher(Long id) {
        Publisher publisher = publisherRepository.findById(id).orElseThrow(() -> new RuntimeException("Not found."));
        publisherRepository.delete(publisher);
    }
}
