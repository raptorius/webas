<?php

    $post = new \Webas\WebasBundle\Entity\Post();
    $post->setUser();
    $post->setLink();
    $post->setDescription();

    $em = $this->getDoctrine()->getManager();
    $em->persist($post);
    $em->flush();