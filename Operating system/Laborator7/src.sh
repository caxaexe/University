#!/bin/bash
if [ -d "$1" ]; then
  for file in "$1"/*; do
    if [ -f "$file" ]; then
      echo "File: $file"
      echo "Symbols: $(wc -c < "$file")"
      echo "Words: $(wc -w < "$file")"
      echo "Lines: $(wc -l < "$file")"
      echo "------------------------"
    fi
  done
else
  echo "Directory $1 not found"
fi
