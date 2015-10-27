--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: a_news_time; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE a_news_time (
    id integer NOT NULL,
    following_u_id integer DEFAULT 0 NOT NULL,
    question_id integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL,
    q_img text DEFAULT ''::text NOT NULL,
    u_img text DEFAULT ''::text NOT NULL,
    generator integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.a_news_time OWNER TO postgres;

--
-- Name: TABLE a_news_time; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE a_news_time IS 'key is time';


--
-- Name: a_news_time_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE a_news_time_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.a_news_time_id_seq OWNER TO postgres;

--
-- Name: a_news_time_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE a_news_time_id_seq OWNED BY a_news_time.id;


--
-- Name: answer_by_pay_q; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE answer_by_pay_q (
    pay_q_id integer NOT NULL,
    correct integer DEFAULT 0 NOT NULL,
    amount integer DEFAULT 0 NOT NULL,
    update_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.answer_by_pay_q OWNER TO postgres;

--
-- Name: answer_by_q; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE answer_by_q (
    question_id integer NOT NULL,
    correct integer DEFAULT 0 NOT NULL,
    amount integer DEFAULT 0 NOT NULL,
    update_at timestamp without time zone DEFAULT now() NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.answer_by_q OWNER TO postgres;

--
-- Name: answer_key_q; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE answer_key_q (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    question_id integer DEFAULT 0 NOT NULL,
    result integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL,
    u_img text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.answer_key_q OWNER TO postgres;

--
-- Name: answer_key_q_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE answer_key_q_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.answer_key_q_id_seq OWNER TO postgres;

--
-- Name: answer_key_q_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE answer_key_q_id_seq OWNED BY answer_key_q.id;


--
-- Name: answer_key_u; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE answer_key_u (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    question_id integer DEFAULT 0 NOT NULL,
    result integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL,
    q_txt text DEFAULT ''::text NOT NULL,
    q_img text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.answer_key_u OWNER TO postgres;

--
-- Name: answer_key_u_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE answer_key_u_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.answer_key_u_id_seq OWNER TO postgres;

--
-- Name: answer_key_u_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE answer_key_u_id_seq OWNED BY answer_key_u.id;


--
-- Name: choice; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE choice (
    choice_0 text DEFAULT ''::text NOT NULL,
    choice_1 text DEFAULT ''::text NOT NULL,
    choice_2 text DEFAULT ''::text NOT NULL,
    choice_3 text DEFAULT ''::text NOT NULL,
    question_id integer DEFAULT 0 NOT NULL,
    reference text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.choice OWNER TO postgres;

--
-- Name: comment; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE comment (
    id integer NOT NULL,
    txt text DEFAULT ''::text NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    question_id integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL,
    u_img text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.comment OWNER TO postgres;

--
-- Name: comment_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE comment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.comment_id_seq OWNER TO postgres;

--
-- Name: comment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE comment_id_seq OWNED BY comment.id;


--
-- Name: follow; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE follow (
    id integer NOT NULL,
    sender integer DEFAULT 0 NOT NULL,
    receiver integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL,
    status integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.follow OWNER TO postgres;

--
-- Name: COLUMN follow.status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN follow.status IS '1=request, 2=confirm, 3=block';


--
-- Name: follow_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE follow_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.follow_id_seq OWNER TO postgres;

--
-- Name: follow_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE follow_id_seq OWNED BY follow.id;


--
-- Name: followed_news; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE followed_news (
    id integer NOT NULL,
    receiver integer DEFAULT 0 NOT NULL,
    sender integer DEFAULT 0 NOT NULL,
    sender_img text DEFAULT ''::text NOT NULL,
    created_at integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.followed_news OWNER TO postgres;

--
-- Name: followed_news_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE followed_news_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.followed_news_id_seq OWNER TO postgres;

--
-- Name: followed_news_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE followed_news_id_seq OWNED BY followed_news.id;


--
-- Name: forum; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE forum (
    id integer NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    txt text DEFAULT ''::text NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    open_time timestamp without time zone DEFAULT now() NOT NULL,
    u_img text DEFAULT ''::text NOT NULL,
    img text DEFAULT ''::text NOT NULL,
    nice integer DEFAULT 0 NOT NULL,
    update_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.forum OWNER TO postgres;

--
-- Name: forum_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE forum_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.forum_id_seq OWNER TO postgres;

--
-- Name: forum_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE forum_id_seq OWNED BY forum.id;


--
-- Name: lg_pack_tran; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lg_pack_tran (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    pack_id integer DEFAULT 0 NOT NULL,
    point integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.lg_pack_tran OWNER TO postgres;

--
-- Name: TABLE lg_pack_tran; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE lg_pack_tran IS 'log pack transaction by 200 point';


--
-- Name: lg_pack_tran_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE lg_pack_tran_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.lg_pack_tran_id_seq OWNER TO postgres;

--
-- Name: lg_pack_tran_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE lg_pack_tran_id_seq OWNED BY lg_pack_tran.id;


--
-- Name: lg_paypal_order; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lg_paypal_order (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    item_name text DEFAULT ''::text NOT NULL,
    paypal_transaction_id text DEFAULT ''::text NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL,
    paypal_time text DEFAULT now() NOT NULL,
    paypal_payer_id text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.lg_paypal_order OWNER TO postgres;

--
-- Name: lg_point_tran; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lg_point_tran (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    point integer DEFAULT 0 NOT NULL,
    txt text DEFAULT ''::text NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.lg_point_tran OWNER TO postgres;

--
-- Name: lg_point_tran_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE lg_point_tran_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.lg_point_tran_id_seq OWNER TO postgres;

--
-- Name: lg_point_tran_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE lg_point_tran_id_seq OWNED BY lg_point_tran.id;


--
-- Name: mt_block_generate; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mt_block_generate (
    usr_id integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.mt_block_generate OWNER TO postgres;

--
-- Name: mt_block_hijack; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mt_block_hijack (
    usr_id integer DEFAULT 0 NOT NULL,
    ymd text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.mt_block_hijack OWNER TO postgres;

--
-- Name: mt_public_news; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mt_public_news (
    id integer NOT NULL,
    txt text DEFAULT ''::text NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.mt_public_news OWNER TO postgres;

--
-- Name: mt_public_news_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mt_public_news_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.mt_public_news_id_seq OWNER TO postgres;

--
-- Name: mt_public_news_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mt_public_news_id_seq OWNED BY mt_public_news.id;


--
-- Name: mt_seo_tag; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mt_seo_tag (
    tag text NOT NULL,
    titile text NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.mt_seo_tag OWNER TO postgres;

--
-- Name: mt_sns_post; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mt_sns_post (
    id integer NOT NULL,
    question_id integer DEFAULT 0 NOT NULL,
    tag text DEFAULT ''::text NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.mt_sns_post OWNER TO postgres;

--
-- Name: mt_sns_post_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mt_sns_post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.mt_sns_post_id_seq OWNER TO postgres;

--
-- Name: mt_sns_post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mt_sns_post_id_seq OWNED BY mt_sns_post.id;


--
-- Name: pack; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pack (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    update_at timestamp without time zone DEFAULT now() NOT NULL,
    txt text DEFAULT ''::text NOT NULL,
    sample_q integer DEFAULT 0 NOT NULL,
    activate integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.pack OWNER TO postgres;

--
-- Name: COLUMN pack.activate; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN pack.activate IS '0=not open, 1=open';


--
-- Name: pack_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pack_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pack_id_seq OWNER TO postgres;

--
-- Name: pack_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pack_id_seq OWNED BY pack.id;


--
-- Name: paid_usr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE paid_usr (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    pack_id integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.paid_usr OWNER TO postgres;

--
-- Name: paid_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE paid_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.paid_user_id_seq OWNER TO postgres;

--
-- Name: paid_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE paid_user_id_seq OWNED BY paid_usr.id;


--
-- Name: pay_answered_news; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pay_answered_news (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    summary integer DEFAULT 0 NOT NULL,
    pay_q_id integer DEFAULT 0 NOT NULL,
    update_at timestamp without time zone DEFAULT now() NOT NULL,
    q_txt text DEFAULT ''::text NOT NULL,
    q_img text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.pay_answered_news OWNER TO postgres;

--
-- Name: pay_answered_news_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pay_answered_news_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pay_answered_news_id_seq OWNER TO postgres;

--
-- Name: pay_answered_news_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pay_answered_news_id_seq OWNED BY pay_answered_news.id;


--
-- Name: pay_choice; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pay_choice (
    choice_0 text DEFAULT ''::text NOT NULL,
    choice_1 text DEFAULT ''::text NOT NULL,
    choice_2 text DEFAULT ''::text NOT NULL,
    choice_3 text DEFAULT ''::text NOT NULL,
    question_id integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.pay_choice OWNER TO postgres;

--
-- Name: pay_comment; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pay_comment (
    id integer NOT NULL,
    txt text NOT NULL,
    usr_id integer NOT NULL,
    pay_q_id integer NOT NULL,
    create_at timestamp without time zone NOT NULL
);


ALTER TABLE public.pay_comment OWNER TO postgres;

--
-- Name: pay_comment_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pay_comment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pay_comment_id_seq OWNER TO postgres;

--
-- Name: pay_comment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pay_comment_id_seq OWNED BY pay_comment.id;


--
-- Name: pay_correct; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pay_correct (
    id integer NOT NULL,
    pay_q_id integer DEFAULT 0 NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.pay_correct OWNER TO postgres;

--
-- Name: pay_correct_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pay_correct_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pay_correct_id_seq OWNER TO postgres;

--
-- Name: pay_correct_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pay_correct_id_seq OWNED BY pay_correct.id;


--
-- Name: pay_incorrect; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pay_incorrect (
    id integer NOT NULL,
    pay_q_id integer NOT NULL,
    usr_id integer NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.pay_incorrect OWNER TO postgres;

--
-- Name: pay_incorrect_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pay_incorrect_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pay_incorrect_id_seq OWNER TO postgres;

--
-- Name: pay_incorrect_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pay_incorrect_id_seq OWNED BY pay_incorrect.id;


--
-- Name: pay_q; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pay_q (
    id integer NOT NULL,
    pack_id integer DEFAULT 0 NOT NULL,
    txt text DEFAULT ''::text NOT NULL,
    img text DEFAULT ''::text NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.pay_q OWNER TO postgres;

--
-- Name: TABLE pay_q; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE pay_q IS 'this question is needed to be paid';


--
-- Name: pay_q_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pay_q_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pay_q_id_seq OWNER TO postgres;

--
-- Name: pay_q_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pay_q_id_seq OWNED BY pay_q.id;


--
-- Name: paypal_order_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE paypal_order_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.paypal_order_id_seq OWNER TO postgres;

--
-- Name: paypal_order_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE paypal_order_id_seq OWNED BY lg_paypal_order.id;


--
-- Name: private_news; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE private_news (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    txt text DEFAULT ''::text NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.private_news OWNER TO postgres;

--
-- Name: private_news_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE private_news_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.private_news_id_seq OWNER TO postgres;

--
-- Name: private_news_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE private_news_id_seq OWNED BY private_news.id;


--
-- Name: question; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE question (
    id integer NOT NULL,
    txt text DEFAULT ''::text NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    img text DEFAULT ''::text NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL,
    open_time timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.question OWNER TO postgres;

--
-- Name: COLUMN question.open_time; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN question.open_time IS 'select open_time - interval ''100 years'' from question where id > 4339';


--
-- Name: question_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE question_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.question_id_seq OWNER TO postgres;

--
-- Name: question_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE question_id_seq OWNED BY question.id;


--
-- Name: quiz_buy; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE quiz_buy (
    id integer NOT NULL,
    buyer integer DEFAULT 0 NOT NULL,
    seller integer DEFAULT 0 NOT NULL,
    question_id integer DEFAULT 0 NOT NULL,
    point integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.quiz_buy OWNER TO postgres;

--
-- Name: quiz_buy_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE quiz_buy_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.quiz_buy_id_seq OWNER TO postgres;

--
-- Name: quiz_buy_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE quiz_buy_id_seq OWNED BY quiz_buy.id;


--
-- Name: send_money; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE send_money (
    id integer NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    email text DEFAULT ''::text NOT NULL,
    yen integer DEFAULT 0 NOT NULL,
    bank_info text DEFAULT ''::text NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.send_money OWNER TO postgres;

--
-- Name: send_money_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE send_money_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.send_money_id_seq OWNER TO postgres;

--
-- Name: send_money_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE send_money_id_seq OWNED BY send_money.id;


--
-- Name: tag; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tag (
    question_id integer DEFAULT 0 NOT NULL,
    txt text DEFAULT ''::text NOT NULL,
    id integer NOT NULL,
    open_time timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.tag OWNER TO postgres;

--
-- Name: TABLE tag; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE tag IS 'quiz tag';


--
-- Name: tag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tag_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.tag_id_seq OWNER TO postgres;

--
-- Name: tag_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tag_id_seq OWNED BY tag.id;


--
-- Name: tag_rank; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tag_rank (
    id integer NOT NULL,
    tag text DEFAULT ''::text NOT NULL,
    usr_id integer DEFAULT 0 NOT NULL,
    create_at timestamp without time zone DEFAULT now() NOT NULL,
    u_img text DEFAULT ''::text NOT NULL,
    u_name text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.tag_rank OWNER TO postgres;

--
-- Name: tag_rank_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tag_rank_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.tag_rank_id_seq OWNER TO postgres;

--
-- Name: tag_rank_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tag_rank_id_seq OWNED BY tag_rank.id;


--
-- Name: usr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usr (
    id integer NOT NULL,
    pv_u_id text DEFAULT ''::text NOT NULL,
    provider integer DEFAULT 0 NOT NULL,
    name text DEFAULT ''::text NOT NULL,
    img text DEFAULT ''::text NOT NULL,
    update_at timestamp without time zone DEFAULT now() NOT NULL,
    point integer DEFAULT 0 NOT NULL,
    introduce text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.usr OWNER TO postgres;

--
-- Name: COLUMN usr.provider; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN usr.provider IS '1=FB, 2=TW, 3=G+, 4=LN';


--
-- Name: usr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.usr_id_seq OWNER TO postgres;

--
-- Name: usr_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usr_id_seq OWNED BY usr.id;


--
-- Name: wh_4choice; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE wh_4choice (
    _id text,
    genre text,
    "Q" text,
    "A1" text,
    "A2" text,
    "A3" text,
    "A4" text
);


ALTER TABLE public.wh_4choice OWNER TO postgres;

--
-- Name: wh_treaty; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE wh_treaty (
    _id text,
    genre text,
    era text,
    year text,
    item text
);


ALTER TABLE public.wh_treaty OWNER TO postgres;

--
-- Name: word; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE word (
    quiz text DEFAULT ''::text NOT NULL,
    answer text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.word OWNER TO postgres;

--
-- Name: TABLE word; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE word IS '4wordmoreadd.php';


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY a_news_time ALTER COLUMN id SET DEFAULT nextval('a_news_time_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY answer_key_q ALTER COLUMN id SET DEFAULT nextval('answer_key_q_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY answer_key_u ALTER COLUMN id SET DEFAULT nextval('answer_key_u_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY comment ALTER COLUMN id SET DEFAULT nextval('comment_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY follow ALTER COLUMN id SET DEFAULT nextval('follow_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY followed_news ALTER COLUMN id SET DEFAULT nextval('followed_news_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY forum ALTER COLUMN id SET DEFAULT nextval('forum_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY lg_pack_tran ALTER COLUMN id SET DEFAULT nextval('lg_pack_tran_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY lg_paypal_order ALTER COLUMN id SET DEFAULT nextval('paypal_order_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY lg_point_tran ALTER COLUMN id SET DEFAULT nextval('lg_point_tran_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mt_public_news ALTER COLUMN id SET DEFAULT nextval('mt_public_news_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mt_sns_post ALTER COLUMN id SET DEFAULT nextval('mt_sns_post_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pack ALTER COLUMN id SET DEFAULT nextval('pack_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY paid_usr ALTER COLUMN id SET DEFAULT nextval('paid_user_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pay_answered_news ALTER COLUMN id SET DEFAULT nextval('pay_answered_news_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pay_comment ALTER COLUMN id SET DEFAULT nextval('pay_comment_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pay_correct ALTER COLUMN id SET DEFAULT nextval('pay_correct_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pay_incorrect ALTER COLUMN id SET DEFAULT nextval('pay_incorrect_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pay_q ALTER COLUMN id SET DEFAULT nextval('pay_q_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY private_news ALTER COLUMN id SET DEFAULT nextval('private_news_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY question ALTER COLUMN id SET DEFAULT nextval('question_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY quiz_buy ALTER COLUMN id SET DEFAULT nextval('quiz_buy_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY send_money ALTER COLUMN id SET DEFAULT nextval('send_money_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tag ALTER COLUMN id SET DEFAULT nextval('tag_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tag_rank ALTER COLUMN id SET DEFAULT nextval('tag_rank_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usr ALTER COLUMN id SET DEFAULT nextval('usr_id_seq'::regclass);


--
-- Name: a_news_time_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY a_news_time
    ADD CONSTRAINT a_news_time_pkey PRIMARY KEY (id);


--
-- Name: answer_by_pay_q_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY answer_by_pay_q
    ADD CONSTRAINT answer_by_pay_q_pkey PRIMARY KEY (pay_q_id);


--
-- Name: answer_by_q_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY answer_by_q
    ADD CONSTRAINT answer_by_q_pkey PRIMARY KEY (question_id);


--
-- Name: answer_key_q_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY answer_key_q
    ADD CONSTRAINT answer_key_q_pkey PRIMARY KEY (id);


--
-- Name: answer_key_u_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY answer_key_u
    ADD CONSTRAINT answer_key_u_pkey PRIMARY KEY (id);


--
-- Name: choice_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY choice
    ADD CONSTRAINT choice_pkey PRIMARY KEY (question_id);


--
-- Name: comment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY comment
    ADD CONSTRAINT comment_pkey PRIMARY KEY (id);


--
-- Name: follow_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY follow
    ADD CONSTRAINT follow_pkey PRIMARY KEY (id);


--
-- Name: followed_news_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY followed_news
    ADD CONSTRAINT followed_news_pkey PRIMARY KEY (id);


--
-- Name: forum_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY forum
    ADD CONSTRAINT forum_pkey PRIMARY KEY (id);


--
-- Name: lg_pack_tran_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lg_pack_tran
    ADD CONSTRAINT lg_pack_tran_pkey PRIMARY KEY (id);


--
-- Name: lg_point_tran_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lg_point_tran
    ADD CONSTRAINT lg_point_tran_pkey PRIMARY KEY (id);


--
-- Name: mt_block_hijack_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mt_block_hijack
    ADD CONSTRAINT mt_block_hijack_pkey PRIMARY KEY (usr_id);


--
-- Name: mt_public_news_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mt_public_news
    ADD CONSTRAINT mt_public_news_pkey PRIMARY KEY (id);


--
-- Name: mt_seo_tag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mt_seo_tag
    ADD CONSTRAINT mt_seo_tag_pkey PRIMARY KEY (tag);


--
-- Name: mt_sns_post_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mt_sns_post
    ADD CONSTRAINT mt_sns_post_pkey PRIMARY KEY (id);


--
-- Name: pack_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pack
    ADD CONSTRAINT pack_pkey PRIMARY KEY (id);


--
-- Name: paid_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY paid_usr
    ADD CONSTRAINT paid_user_pkey PRIMARY KEY (id, usr_id, pack_id, create_at);


--
-- Name: pay_answered_news_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pay_answered_news
    ADD CONSTRAINT pay_answered_news_pkey PRIMARY KEY (id);


--
-- Name: pay_comment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pay_comment
    ADD CONSTRAINT pay_comment_pkey PRIMARY KEY (id);


--
-- Name: pay_q_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pay_q
    ADD CONSTRAINT pay_q_pkey PRIMARY KEY (id);


--
-- Name: paypal_order_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lg_paypal_order
    ADD CONSTRAINT paypal_order_pkey PRIMARY KEY (id);


--
-- Name: private_news_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY private_news
    ADD CONSTRAINT private_news_pkey PRIMARY KEY (id);


--
-- Name: question_id_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pay_choice
    ADD CONSTRAINT question_id_pkey PRIMARY KEY (question_id);


--
-- Name: question_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY question
    ADD CONSTRAINT question_pkey PRIMARY KEY (id);


--
-- Name: quiz_buy_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY quiz_buy
    ADD CONSTRAINT quiz_buy_pkey PRIMARY KEY (id);


--
-- Name: send_money_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY send_money
    ADD CONSTRAINT send_money_pkey PRIMARY KEY (id);


--
-- Name: sender_receiver; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY follow
    ADD CONSTRAINT sender_receiver UNIQUE (sender, receiver);


--
-- Name: tag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tag
    ADD CONSTRAINT tag_pkey PRIMARY KEY (id);


--
-- Name: tag_rank_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tag_rank
    ADD CONSTRAINT tag_rank_pkey PRIMARY KEY (id);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usr
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: a_key_q_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX a_key_q_idx ON answer_key_q USING btree (question_id, create_at);


--
-- Name: a_key_u_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX a_key_u_idx ON answer_key_u USING btree (usr_id, create_at);


--
-- Name: follow_receiver; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX follow_receiver ON follow USING btree (receiver);


--
-- Name: follow_sender; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX follow_sender ON follow USING btree (sender);


--
-- Name: followed_news_receiver; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX followed_news_receiver ON followed_news USING btree (receiver);


--
-- Name: news_create_at_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX news_create_at_idx ON a_news_time USING btree (create_at);


--
-- Name: news_following_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX news_following_idx ON a_news_time USING btree (following_u_id);


--
-- Name: news_generator_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX news_generator_idx ON a_news_time USING btree (generator);


--
-- Name: news_question_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX news_question_idx ON a_news_time USING btree (question_id);


--
-- Name: pay_an_news_u; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX pay_an_news_u ON pay_answered_news USING btree (usr_id);


--
-- Name: qu_u; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX qu_u ON question USING btree (usr_id);


--
-- Name: session_block_usr_id; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX session_block_usr_id ON mt_block_hijack USING btree (usr_id);


--
-- Name: tag_txt; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX tag_txt ON tag USING btree (txt);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

