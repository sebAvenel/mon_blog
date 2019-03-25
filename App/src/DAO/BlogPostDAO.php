<?php

namespace App\src\DAO;

use App\src\model\BlogPost;

/**
 * Class BlogPostDAO
 * @package App\src\DAO
 */
class BlogPostDAO extends DAO
{
    /**
     * Return a list of blog posts
     *
     * @return array
     */
    public function getBlogPosts()
    {
        $sql = 'SELECT blog_post.id, blog_post.title, blog_post.chapo, blog_post.content, DATE_FORMAT(blog_post.createdAt, "%d/%m/%Y") AS createdAt, DATE_FORMAT(blog_post.updatedAt, "%d/%m/%Y") AS updatedAt, blog_post.idUser, users.id AS userId, users.name AS name
                FROM blog_post
                INNER JOIN users
                  ON blog_post.idUser = users.id
                ORDER BY id DESC';
        $result = $this->sql($sql);
        if ($result) {
            $blogPosts = [];
            foreach ($result as $row) {
                $blogPostId = $row['id'];
                $blogPosts[$blogPostId] = $this->buildObjectBlogPost($row);
            }
            return $blogPosts;
        } else {
            return null;
        }
    }

    /**
     * Return a blog post
     *
     * @param int $idBlogPost
     * @return BlogPost
     */
    public function getBlogPost($idBlogPost)
    {
        $sql = 'SELECT blog_post.id, blog_post.title, blog_post.chapo, blog_post.content, DATE_FORMAT(blog_post.createdAt, "%d/%m/%Y") AS createdAt, DATE_FORMAT(blog_post.updatedAt, "%d/%m/%Y") AS updatedAt, blog_post.idUser, users.id AS userId, users.name AS name
                FROM blog_post
                INNER JOIN users
                  ON blog_post.idUser = users.id
                WHERE  blog_post.id = ?';
        $result = $this->sql($sql, [$idBlogPost]);
        $row = $result->fetch();
        if ($row) {
            return $this->buildObjectBlogPost($row);
        } else {
            return null;
        }
    }

    /**
     * Update a blog post
     *
     * @param $title
     * @param $chapo
     * @param $content
     * @param $id
     * @return bool|\PDOStatement
     */
    public function updateBlogPost($title, $chapo, $content, $id)
    {
        $sql = 'UPDATE blog_post SET title = :title, chapo = :chapo, content = :content, updatedAt = NOW() WHERE id = :id';
        $arrayUpdateComment = [
            'title' => $title,
            'chapo' => $chapo,
            'content' => $content,
            'id' => $id
        ];
        return $this->sql($sql, $arrayUpdateComment);
    }

    /**
     * Delete a blog post
     *
     * @param $title
     * @param $chapo
     * @param $content
     */
    public function addBlogPost($title, $chapo, $content)
    {
        $sql = 'INSERT INTO blog_post(title, chapo, content, createdAt, updatedAt, idUser)
                VALUES(:title, :title, :content, NOW(), NOW(), :idUser)';
        $arrayAddComment = [
            'title' => $title,
            'chapo' => $chapo,
            'content' => $content,
            'idUser' => (int) $_SESSION['infosUser']['idUser']
        ];
        $this->sql($sql, $arrayAddComment);
    }

    /**
     * Delete a blog post
     *
     * @param $idBlogPost
     */
    public function deleteBlogPost($idBlogPost)
    {
        $sql = 'DELETE FROM blog_post WHERE id = ' . $idBlogPost;
        $this->sql($sql);
    }

    /**
     * Build a blog post object
     *
     * @param array $row
     * @return BlogPost
     */
    private function buildObjectBlogPost(array $row)
    {
        $article = new BlogPost();
        $article->setId($row['id']);
        $article->setTitle($row['title']);
        $article->setChapo($row['chapo']);
        $article->setContent($row['content']);
        $article->setCreatedAt($row['createdAt']);
        $article->setUpdatedAt($row['updatedAt']);
        $article->setIdUser($row['idUser']);
        $article->setUserId($row['userId']);
        $article->setUserName($row['name']);

        return $article;
    }
}
