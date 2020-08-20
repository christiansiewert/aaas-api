<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

/**
 * Creates an AaaS User
 *
 * @author Christian Siewert <christian@sieware.international>
 */
class CreateUserCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'acl:create-user';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator)
    {
        parent::__construct();

        $this->em = $em;
        $this->encoder = $encoder;
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setDescription('Creates a new AaaS user.')
            ->setHelp('This command allows you to create a AaaS user...')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
            ->addOption('admin', null, InputOption::VALUE_OPTIONAL, 'admin option', false);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $admin = $input->getOption('admin');

        $user = new Customer();
        $user->setEmail($email);

        if (count($this->validator->validate($user->getEmail(), new Email())) > 0) {
            throw new InvalidArgumentException('Invalid email address.');
        }

        if (count($this->validator->validate($user, new UniqueEntity(['fields' => 'email']))) > 0) {
            throw new InvalidArgumentException('Email address already exists.');
        }

        $user->setRoles($admin === null ? ['ROLE_AAAS_ADMIN'] : ['ROLE_AAAS_USER']);
        $user->setPassword($this->encoder->encodePassword($user, $password));

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln(sprintf('User created with Email: %s', $user->getEmail()));

        return Command::SUCCESS;
    }
}